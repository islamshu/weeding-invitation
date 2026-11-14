import { computed, ref } from 'vue';

const STORAGE_KEY = 'dawati:music-muted';
const BAR_SECONDS = 3.6;
const MASTER_VOLUME = 0.55;

/**
 * A tiny, asset-free ambient score generated with the Web Audio API. Notes are
 * synthesised on demand, so the invitation stays lightweight and the audio
 * starts from the guest's envelope click (a real user gesture).
 */
function readMutedPreference() {
    if (typeof window === 'undefined') return false;
    try {
        return window.localStorage.getItem(STORAGE_KEY) === '1';
    } catch {
        return false;
    }
}

function persistMutedPreference(value) {
    if (typeof window === 'undefined') return;
    try {
        window.localStorage.setItem(STORAGE_KEY, value ? '1' : '0');
    } catch {
        // Private mode / storage disabled — the preference simply won't persist.
    }
}

const muted = ref(readMutedPreference());
const playing = ref(false);
const supported = typeof window !== 'undefined' && Boolean(window.AudioContext || window.webkitAudioContext);

let context = null;
let master = null;
let scheduler = null;
let bar = 0;
const liveNodes = new Set();

const chords = [
    [261.63, 329.63, 392.00, 523.25, 659.25], // C major
    [220.00, 261.63, 329.63, 440.00, 523.25], // A minor
    [174.61, 220.00, 261.63, 349.23, 440.00], // F major
    [196.00, 246.94, 293.66, 392.00, 493.88], // G major
];

const bassNotes = [65.41, 55.00, 43.65, 49.00];
const arpeggio = [0, 1, 2, 3, 4, 3, 2, 1];

function ensureContext() {
    if (context && context.state !== 'closed') return context;
    if (typeof window === 'undefined') return null;

    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
    if (!AudioContextClass) return null;

    context = new AudioContextClass();
    master = context.createGain();
    master.gain.value = 0;

    const filter = context.createBiquadFilter();
    filter.type = 'lowpass';
    filter.frequency.value = 3600;
    filter.Q.value = 0.4;
    master.connect(filter);
    filter.connect(context.destination);

    // A short, soft echo gives the arpeggio a chapel-like tail.
    const delay = context.createDelay(1);
    delay.delayTime.value = 0.32;
    const feedback = context.createGain();
    feedback.gain.value = 0.22;
    const wet = context.createGain();
    wet.gain.value = 0.18;
    master.connect(delay);
    delay.connect(feedback);
    feedback.connect(delay);
    delay.connect(wet);
    wet.connect(filter);

    return context;
}

function playNote(frequency, at, duration, peak, type = 'triangle', attack = 0.02) {
    if (!context || !master) return;

    const oscillator = context.createOscillator();
    const gain = context.createGain();
    const start = Math.max(at, context.currentTime + 0.01);

    oscillator.type = type;
    oscillator.frequency.setValueAtTime(frequency, start);
    gain.gain.setValueAtTime(0.0001, start);
    gain.gain.exponentialRampToValueAtTime(Math.max(peak, 0.0002), start + attack);
    gain.gain.exponentialRampToValueAtTime(0.0001, start + duration);

    oscillator.connect(gain);
    gain.connect(master);
    oscillator.start(start);
    oscillator.stop(start + duration + 0.05);

    liveNodes.add(oscillator);
    oscillator.onended = () => {
        liveNodes.delete(oscillator);
        try {
            gain.disconnect();
        } catch {
            // Node already disconnected.
        }
    };
}

function scheduleBar() {
    if (!context || !master) return;

    const now = context.currentTime + 0.08;
    const chord = chords[bar % chords.length];
    const bass = bassNotes[bar % bassNotes.length];

    // Warm sustained pad.
    chord.slice(0, 4).forEach((frequency, index) => {
        playNote(frequency, now + index * 0.03, BAR_SECONDS - 0.25, 0.016, 'sine', 0.75);
        playNote(frequency * 2, now + index * 0.03, BAR_SECONDS - 0.45, 0.005, 'sine', 1.1);
    });

    // Gentle bass foundation.
    playNote(bass, now, BAR_SECONDS, 0.028, 'sine', 0.5);
    playNote(bass * 2, now, BAR_SECONDS - 0.4, 0.01, 'triangle', 0.6);

    // Harp-like arpeggio.
    arpeggio.forEach((index, step) => {
        const at = now + step * (BAR_SECONDS / arpeggio.length);
        playNote(chord[index] * 2, at, 1.35, 0.026, 'triangle', 0.012);
        playNote(chord[index], at, 1.05, 0.009, 'sine', 0.02);
    });

    // A small sparkle on the first beat of every other bar.
    if (bar % 2 === 0) {
        playNote(chord[4] * 2, now + 0.05, 1.8, 0.008, 'sine', 0.04);
    }

    bar += 1;
}

async function start() {
    if (!supported) return false;
    if (playing.value) return true;

    const audio = ensureContext();
    if (!audio) return false;

    if (audio.state === 'suspended') {
        try {
            await audio.resume();
        } catch {
            return false;
        }
    }

    playing.value = true;
    bar = 0;
    scheduleBar();
    scheduler = window.setInterval(scheduleBar, BAR_SECONDS * 1000);

    const now = audio.currentTime;
    master.gain.cancelScheduledValues(now);
    master.gain.setValueAtTime(Math.max(master.gain.value, 0.0001), now);
    master.gain.exponentialRampToValueAtTime(muted.value ? 0.0001 : MASTER_VOLUME, now + 0.8);

    return true;
}

function stop() {
    if (scheduler) {
        window.clearInterval(scheduler);
        scheduler = null;
    }

    playing.value = false;

    if (!context || !master) return;

    const audio = context;
    const bus = master;
    const now = audio.currentTime;

    bus.gain.cancelScheduledValues(now);
    bus.gain.setValueAtTime(Math.max(bus.gain.value, 0.0001), now);
    bus.gain.exponentialRampToValueAtTime(0.0001, now + 0.3);

    window.setTimeout(() => {
        liveNodes.forEach((node) => {
            try {
                node.stop();
            } catch {
                // Oscillator already stopped.
            }
        });
        liveNodes.clear();
        audio.close().catch(() => {});
        if (context === audio) {
            context = null;
            master = null;
        }
    }, 650);
}

function toggleMute() {
    muted.value = !muted.value;
    persistMutedPreference(muted.value);

    if (context && master && playing.value) {
        const now = context.currentTime;
        master.gain.cancelScheduledValues(now);
        master.gain.setValueAtTime(Math.max(master.gain.value, 0.0001), now);
        master.gain.exponentialRampToValueAtTime(muted.value ? 0.0001 : MASTER_VOLUME, now + 0.35);
    }
}

export function useInvitationMusic() {
    return {
        supported,
        muted,
        playing,
        isSilent: computed(() => muted.value || !playing.value),
        start,
        stop,
        toggleMute,
    };
}
