import { getTemplate, templates } from '../data/templates';

export const FONT_STACKS = {
    cairo: { ar: "'Cairo', sans-serif", en: "'Cairo', sans-serif" },
    tajawal: { ar: "'Tajawal', sans-serif", en: "'Tajawal', sans-serif" },
    naskh: { ar: "'Noto Naskh Arabic', serif", en: "'Noto Naskh Arabic', serif" },
    playfair: { ar: "'Noto Naskh Arabic', serif", en: "'Playfair Display', serif" },
    cormorant: { ar: "'Noto Naskh Arabic', serif", en: "'Cormorant Garamond', serif" },
    montserrat: { ar: "'Tajawal', sans-serif", en: "'Montserrat', sans-serif" },
};

export const designPresets = [
    {
        key: 'champagne',
        name_ar: 'شامبانيا وذهبي',
        name_en: 'Champagne & Gold',
        colors: { primary: '#8a6a3b', secondary: '#c9a86a', background: '#fbf7f0', text: '#2f2a24', decorative: '#c9a86a' },
    },
    {
        key: 'burgundy',
        name_ar: 'عنابي وذهبي',
        name_en: 'Burgundy & Gold',
        colors: { primary: '#6d1f33', secondary: '#c9a86a', background: '#fbf3ea', text: '#34241f', decorative: '#b08d57' },
    },
    {
        key: 'ivory',
        name_ar: 'عاجي وشمبانيا',
        name_en: 'Ivory & Champagne',
        colors: { primary: '#9b845e', secondary: '#e6d2ae', background: '#fffdf8', text: '#3a342b', decorative: '#d6b984' },
    },
    {
        key: 'silver',
        name_ar: 'أبيض وفضي',
        name_en: 'White & Silver',
        colors: { primary: '#7f8891', secondary: '#c8ced4', background: '#ffffff', text: '#2f3439', decorative: '#b7c0c8' },
    },
    {
        key: 'rose',
        name_ar: 'وردي وذهب وردي',
        name_en: 'Pink & Rose Gold',
        colors: { primary: '#b2637a', secondary: '#e0ae9f', background: '#fff6f7', text: '#4b2f36', decorative: '#d9a0b0' },
    },
    {
        key: 'emerald',
        name_ar: 'زمردي وذهبي',
        name_en: 'Emerald & Gold',
        colors: { primary: '#1f5d4a', secondary: '#c9a86a', background: '#f6f4ea', text: '#26332d', decorative: '#b08d57' },
    },
];

export const titleOptions = [
    { key: 'none', ar: '', en: '' },
    { key: 'mr', ar: 'السيد', en: 'Mr.' },
    { key: 'engineer', ar: 'المهندس', en: 'Eng.' },
    { key: 'doctor', ar: 'الدكتور', en: 'Dr.' },
    { key: 'hajj', ar: 'الحاج', en: 'Hajj' },
    { key: 'sheikh', ar: 'الشيخ', en: 'Sheikh' },
    { key: 'professor', ar: 'الأستاذ', en: 'Mr.' },
    { key: 'custom', ar: '', en: '' },
];

export const designationOptions = [
    { key: 'none', ar: '', en: '' },
    { key: 'groom_father', ar: 'والد العريس', en: 'Father of the Groom' },
    { key: 'bride_father', ar: 'والد العروس', en: 'Father of the Bride' },
    { key: 'groom_brother', ar: 'أخ العريس', en: 'Brother of the Groom' },
    { key: 'bride_brother', ar: 'أخ العروس', en: 'Brother of the Bride' },
    { key: 'groom_uncle', ar: 'عم العريس', en: "Groom's Uncle" },
    { key: 'bride_uncle', ar: 'عم العروس', en: "Bride's Uncle" },
    { key: 'sons_of_deceased', ar: 'أبناء المرحوم', en: 'Sons of the late' },
    { key: 'family_of_deceased', ar: 'عائلة المرحوم', en: 'Family of the late' },
    { key: 'custom', ar: '', en: '' },
];

export function optionLabel(options, key, lang = 'ar') {
    const option = options.find((item) => item.key === key);
    if (!option) return '';
    return lang === 'ar' ? option.ar : option.en;
}

export function defaultWakil() {
    return {
        title_key: 'none',
        title_custom_ar: '',
        title_custom_en: '',
        name_ar: '',
        name_en: '',
        kunya_ar: '',
        kunya_en: '',
        designation_key: 'none',
        designation_custom_ar: '',
        designation_custom_en: '',
        intro_ar: '',
        intro_en: '',
        show_title: true,
        show_name: true,
        show_kunya: true,
        show_designation: true,
    };
}

export function defaultContent() {
    return {
        title_ar: 'دعوة زفاف',
        title_en: 'Wedding Invitation',
        invite_line_ar: 'يتشرفان بدعوة سيادتكم',
        invite_line_en: 'It is our honour to invite you',
        intro_ar: 'بكل محبة وفرح، نتشرف بدعوتكم لمشاركتنا فرحة العمر.',
        intro_en: 'With love and joy, we invite you to share the happiest day of our lives.',
        message_ar: 'يسرنا ويشرفنا دعوتكم لحضور حفل زفافنا، سائلين الله أن يجمعنا على الخير والمحبة.',
        message_en: 'It is our honour to invite you to celebrate our wedding with us.',
        religious_ar: '﴿وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً﴾',
        religious_en: '',
        closing_ar: 'حضوركم شرف لنا ويضيف لفرحتنا بهجة.',
        closing_en: 'Your presence is our greatest honour.',
        additional_ar: '',
        additional_en: '',
    };
}

export function defaultEvents() {
    return {
        wedding_date: '',
        wedding_time: '18:30',
        venue_name_ar: '',
        venue_name_en: '',
        venue_address_ar: '',
        venue_address_en: '',
        maps_url: '',
        henna_enabled: false,
        henna_date: '',
        henna_time: '',
        henna_location_ar: '',
        henna_location_en: '',
        reception_enabled: false,
        reception_date: '',
        reception_time: '',
        reception_location_ar: '',
        reception_location_en: '',
    };
}

export function defaultDesign(templateKey = 'classic_royal') {
    const template = getTemplate(templateKey);

    return {
        preset: 'champagne',
        primary_color: template.palette.primary,
        secondary_color: template.palette.secondary,
        background_color: template.palette.background,
        text_color: template.palette.text,
        decorative_color: template.palette.decorative,
        font_family: 'auto',
        background_style: 'soft',
        border_style: 'ornate',
        envelope_style: template.envelope.style,
        couple_layout: 'groom_right',
        show_centerpiece: true,
        show_florals: true,
        show_monogram: true,
        show_hearts: false,
        effects: { petals: false, sparkles: false, confetti: false },
    };
}

export function defaultForm() {
    return {
        intent: 'save',
        return_step: 1,
        slug: '',
        enable_english: false,
        groom_name_ar: '',
        groom_name_en: '',
        bride_name_ar: '',
        bride_name_en: '',
        couple_note_ar: '',
        couple_note_en: '',
        groom_wakil: defaultWakil(),
        bride_wakil: defaultWakil(),
        invitation_content: defaultContent(),
        event_details: defaultEvents(),
        design_settings: defaultDesign(),
        template_key: 'classic_royal',
        cover_image: null,
        background_image: null,
        decorative_image: null,
        cover_preview_url: null,
        background_preview_url: null,
        decorative_preview_url: null,
        remove_cover_image: false,
        remove_background_image: false,
        remove_decorative_image: false,
    };
}

export function formFromInvitation(invitation) {
    const base = defaultForm();
    if (!invitation) return base;

    return {
        ...base,
        slug: invitation.slug ?? '',
        enable_english: Boolean(invitation.enable_english),
        groom_name_ar: invitation.groom_name_ar ?? '',
        groom_name_en: invitation.groom_name_en ?? '',
        bride_name_ar: invitation.bride_name_ar ?? '',
        bride_name_en: invitation.bride_name_en ?? '',
        couple_note_ar: invitation.couple_note_ar ?? '',
        couple_note_en: invitation.couple_note_en ?? '',
        groom_wakil: { ...defaultWakil(), ...(invitation.groom_wakil ?? {}) },
        bride_wakil: { ...defaultWakil(), ...(invitation.bride_wakil ?? {}) },
        invitation_content: { ...defaultContent(), ...(invitation.invitation_content ?? {}) },
        event_details: { ...defaultEvents(), ...(invitation.event_details ?? {}) },
        design_settings: {
            ...defaultDesign(invitation.template_key),
            ...(invitation.design_settings ?? {}),
            effects: {
                ...defaultDesign().effects,
                ...(invitation.design_settings?.effects ?? {}),
            },
        },
        template_key: invitation.template_key ?? 'classic_royal',
        cover_preview_url: invitation.cover_image_url ?? null,
        background_preview_url: invitation.background_image_url ?? null,
        decorative_preview_url: invitation.decorative_image_url ?? null,
    };
}

export function buildPreviewInvitation(form) {
    return {
        slug: form.slug || 'your-wedding',
        status: 'draft',
        enable_english: form.enable_english,
        template_key: form.template_key,
        groom_name_ar: form.groom_name_ar,
        groom_name_en: form.groom_name_en,
        bride_name_ar: form.bride_name_ar,
        bride_name_en: form.bride_name_en,
        couple_note_ar: form.couple_note_ar,
        couple_note_en: form.couple_note_en,
        groom_wakil: form.groom_wakil,
        bride_wakil: form.bride_wakil,
        invitation_content: form.invitation_content,
        event_details: form.event_details,
        design_settings: form.design_settings,
        event_start_iso: form.event_details?.wedding_date
            ? `${form.event_details.wedding_date}T${form.event_details.wedding_time || '18:00'}:00`
            : null,
        cover_image_url: form.cover_preview_url ?? null,
        background_image_url: form.background_preview_url ?? null,
        decorative_image_url: form.decorative_preview_url ?? null,
        public_url: null,
        calendar_url: null,
    };
}

export function resolveFonts(design, template) {
    // A user-selected font is applied to both languages. In "auto" mode, each
    // language keeps its template's intended font instead of inheriting the
    // English font key, which previously made Arabic text ignore the template's
    // Arabic font and appear not to change.
    const selected = design?.font_family && design.font_family !== 'auto'
        ? design.font_family
        : null;

    const arKey = selected ?? template?.fonts?.ar ?? 'naskh';
    const enKey = selected ?? template?.fonts?.en ?? 'playfair';

    return {
        ar: FONT_STACKS[arKey]?.ar ?? FONT_STACKS.naskh.ar,
        en: FONT_STACKS[enKey]?.en ?? FONT_STACKS.playfair.en,
    };
}

export function formatDate(value, lang = 'ar') {
    if (!value) return '';
    const [year, month, day] = String(value).split('-').map(Number);
    if (!year || !month || !day) return value;
    const date = new Date(year, month - 1, day, 12, 0, 0);

    try {
        return new Intl.DateTimeFormat(lang === 'ar' ? 'ar-EG' : 'en-GB', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        }).format(date);
    } catch {
        return value;
    }
}

export function formatShortDate(value, lang = 'ar') {
    if (!value) return '';
    const [year, month, day] = String(value).split('-').map(Number);
    if (!year || !month || !day) return value;
    const date = new Date(year, month - 1, day, 12, 0, 0);

    try {
        return new Intl.DateTimeFormat(lang === 'ar' ? 'ar-EG' : 'en-GB', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        }).format(date);
    } catch {
        return value;
    }
}

export function formatTime(value, lang = 'ar') {
    if (!value) return '';
    const [hour, minute] = String(value).split(':').map(Number);
    const date = new Date(2000, 0, 1, Number.isFinite(hour) ? hour : 18, Number.isFinite(minute) ? minute : 0);

    try {
        return new Intl.DateTimeFormat(lang === 'ar' ? 'ar-EG' : 'en-GB', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
        }).format(date);
    } catch {
        return value;
    }
}

function familyName(name) {
    const parts = String(name ?? '').trim().split(/\s+/).filter(Boolean);
    return parts.length ? parts[parts.length - 1] : '';
}

export function monogram(groomName, brideName, lang = 'ar') {
    const groomFamily = familyName(groomName);
    const brideFamily = familyName(brideName);

    // English invitations keep the classic two-initial monogram.
    if (lang === 'en') {
        const first = (groomName ?? '').trim().charAt(0);
        const second = (brideName ?? '').trim().charAt(0);
        return `${first}${second}`.trim() || '♥';
    }

    const family = groomFamily || brideFamily;
    if (!family) return '♥';
    return `أفراح ال ${family}`;
}

function pickStrict(ar, en, lang, fallback = true) {
    if (lang === 'en') {
        return en || (fallback ? ar : '');
    }
    return ar;
}

function buildWakil(wakil, lang, fallback = true) {
    const source = wakil ?? {};
    const titlePreset = optionLabel(titleOptions, source.title_key, lang);
    const title = source.title_key === 'custom'
        ? pickStrict(source.title_custom_ar, source.title_custom_en, lang, fallback)
        : titlePreset;
    const name = pickStrict(source.name_ar, source.name_en, lang, fallback);
    const kunya = pickStrict(source.kunya_ar, source.kunya_en, lang, fallback);
    const designationPreset = optionLabel(designationOptions, source.designation_key, lang);
    const designation = source.designation_key === 'custom'
        ? pickStrict(source.designation_custom_ar, source.designation_custom_en, lang, fallback)
        : designationPreset;
    const intro = pickStrict(source.intro_ar, source.intro_en, lang, fallback);

    const showTitle = source.show_title !== false;
    const showName = source.show_name !== false;
    const showKunya = source.show_kunya !== false;
    const showDesignation = source.show_designation !== false;

    return {
        title: showTitle ? title : '',
        name: showName ? name : '',
        kunya: showKunya ? kunya : '',
        designation: showDesignation ? designation : '',
        intro,
        isEmpty: !(showName && name) && !(showTitle && title) && !(showDesignation && designation),
    };
}

export function buildView(invitation, lang = 'ar') {
    const template = getTemplate(invitation?.template_key);
    const englishEnabled = Boolean(invitation?.enable_english);
    const activeLang = lang === 'en' && englishEnabled ? 'en' : 'ar';
    const strict = activeLang === 'en';
    const content = invitation?.invitation_content ?? {};
    const events = invitation?.event_details ?? {};
    const design = { ...defaultDesign(invitation?.template_key), ...(invitation?.design_settings ?? {}) };
    const fonts = resolveFonts(design, template);
    const groomName = pickStrict(invitation?.groom_name_ar, invitation?.groom_name_en, activeLang);
    const brideName = pickStrict(invitation?.bride_name_ar, invitation?.bride_name_en, activeLang);
    const groomWakil = buildWakil(invitation?.groom_wakil, activeLang);
    const brideWakil = buildWakil(invitation?.bride_wakil, activeLang);
    const groomRight = design.couple_layout !== 'groom_left';

    const venueName = pickStrict(events.venue_name_ar, events.venue_name_en, activeLang);
    const venueAddress = pickStrict(events.venue_address_ar, events.venue_address_en, activeLang);

    // The lead line was introduced after the first invitations were saved, so
    // legacy records without the key still receive the elegant default while an
    // intentionally cleared field stays empty.
    const hasInviteLine = Object.prototype.hasOwnProperty.call(content, 'invite_line_ar')
        || Object.prototype.hasOwnProperty.call(content, 'invite_line_en');
    const inviteLine = hasInviteLine
        ? pickStrict(content.invite_line_ar, content.invite_line_en, activeLang, !strict)
        : (activeLang === 'ar' ? 'يتشرفان بدعوة سيادتكم' : 'It is our honour to invite you');

    return {
        lang: activeLang,
        dir: activeLang === 'ar' ? 'rtl' : 'ltr',
        englishEnabled,
        template,
        design,
        fonts,
        fontFamily: fonts[activeLang],
        couple: {
            groom: groomName,
            bride: brideName,
            note: pickStrict(invitation?.couple_note_ar, invitation?.couple_note_en, activeLang, !strict),
            monogram: monogram(
                pickStrict(invitation?.groom_wakil?.name_ar, invitation?.groom_wakil?.name_en, activeLang) || groomName,
                pickStrict(invitation?.bride_wakil?.name_ar, invitation?.bride_wakil?.name_en, activeLang) || brideName,
                activeLang
            ),
            groomRight,
        },
        wakils: {
            groom: groomWakil,
            bride: brideWakil,
            hasAny: !groomWakil.isEmpty || !brideWakil.isEmpty,
        },
        content: {
            title: pickStrict(content.title_ar, content.title_en, activeLang, !strict) || (activeLang === 'ar' ? 'دعوة زفاف' : 'Wedding Invitation'),
            inviteLine,
            intro: pickStrict(content.intro_ar, content.intro_en, activeLang, !strict),
            message: pickStrict(content.message_ar, content.message_en, activeLang, !strict),
            religious: pickStrict(content.religious_ar, content.religious_en, activeLang, !strict),
            closing: pickStrict(content.closing_ar, content.closing_en, activeLang, !strict),
            additional: pickStrict(content.additional_ar, content.additional_en, activeLang, !strict),
        },
        event: {
            date: events.wedding_date || '',
            dateFormatted: formatDate(events.wedding_date, activeLang),
            dateShort: formatShortDate(events.wedding_date, activeLang),
            time: events.wedding_time || '',
            timeFormatted: formatTime(events.wedding_time, activeLang),
            venueName,
            venueAddress,
            mapsUrl: events.maps_url || '',
            startIso: invitation?.event_start_iso || null,
            henna: {
                enabled: Boolean(events.henna_enabled),
                date: events.henna_date || '',
                dateFormatted: formatDate(events.henna_date, activeLang),
                timeFormatted: formatTime(events.henna_time, activeLang),
                location: pickStrict(events.henna_location_ar, events.henna_location_en, activeLang),
            },
            reception: {
                enabled: Boolean(events.reception_enabled),
                date: events.reception_date || '',
                dateFormatted: formatDate(events.reception_date, activeLang),
                timeFormatted: formatTime(events.reception_time, activeLang),
                location: pickStrict(events.reception_location_ar, events.reception_location_en, activeLang),
            },
        },
        images: {
            cover: invitation?.cover_image_url || null,
            background: invitation?.background_image_url || null,
            decorative: invitation?.decorative_image_url || null,
        },
        publicUrl: invitation?.public_url || null,
        calendarUrl: invitation?.calendar_url || null,
        status: invitation?.status || 'draft',
    };
}

export function designStyle(design, fonts) {
    return {
        '--inv-primary': design.primary_color,
        '--inv-secondary': design.secondary_color,
        '--inv-bg': design.background_color,
        '--inv-text': design.text_color,
        '--inv-decor': design.decorative_color,
        '--inv-font': fonts?.ar || fonts?.en || "'Cairo', sans-serif",
    };
}

export const contentSuggestions = {
    title: {
        ar: ['دعوة زفاف', 'دعوة عرس', 'بسم الله نبدأ', 'فرحة العمر'],
        en: ['Wedding Invitation', 'Our Wedding', 'A Celebration of Love', 'Save the Date'],
    },
    invite_line: {
        ar: [
            'يتشرفان بدعوة سيادتكم',
            'يتشرفان بدعوتكم لمشاركتهما فرحة العمر',
            'بكل الحب والفرح، يدعوانكم لمشاركتهما أجمل لحظات حياتهما',
        ],
        en: [
            'It is our honour to invite you',
            'Together with joy, we invite you to share our happiest day',
            'With love and gratitude, we would be honoured by your presence',
        ],
    },
    intro: {
        ar: [
            'بكل محبة وفرح، نتشرف بدعوتكم لمشاركتنا فرحة العمر.',
            'في جوّ من الفرح والمحبة، نتشرف بدعوتكم لحضور حفل زفافنا.',
            'بقلوب مليئة بالامتنان، ندعوكم لمشاركتنا أجمل لحظات حياتنا.',
        ],
        en: [
            'With love and joy, we invite you to share the happiest day of our lives.',
            'In a celebration of love, we are honoured to invite you to our wedding.',
        ],
    },
    message: {
        ar: [
            'يسرنا ويشرفنا دعوتكم لحضور حفل زفافنا، سائلين الله أن يجمعنا على الخير والمحبة.',
            'بكل الحب والفرح، نتشرف بدعوتكم لمشاركتنا ليلة العمر وحضور حفل زفافنا.',
            'حضوركم يكتمل به فرحنا، ونتشرف بوجودكم بين أهالينا وأحبابنا.',
        ],
        en: [
            'It is our honour to invite you to celebrate our wedding with us.',
            'Your presence will make our joy complete. We would be honoured to have you with us.',
        ],
    },
    religious: {
        ar: [
            '﴿وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً﴾',
            'بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ',
            '«بَارَكَ اللَّهُ لَكُمَا وَبَارَكَ عَلَيْكُمَا وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ»',
        ],
        en: [
            '“And among His signs is that He created for you mates from among yourselves, that you may dwell in tranquillity with them.”',
            'In the name of God, the Most Gracious, the Most Merciful',
        ],
    },
    closing: {
        ar: [
            'حضوركم شرف لنا ويضيف لفرحتنا بهجة.',
            'بانتظاركم لنحتفل معًا بأجمل ليلة.',
            'شكرًا لمشاركتكم فرحتنا، حضوركم أغلى هدية.',
        ],
        en: [
            'Your presence is our greatest honour.',
            'We cannot wait to celebrate with you.',
            'Thank you for sharing our joy.',
        ],
    },
    additional: {
        ar: [
            'يرجى تأكيد الحضور قبل الموعد بأسبوع.',
            'نعتذر عن حضور الأطفال في حفل الزفاف.',
            'الحفل مخصص للعائلة والأصدقاء، شكرًا لتفهمكم.',
        ],
        en: [
            'Please confirm your attendance one week before the event.',
            'We kindly request an adults-only celebration.',
            'The celebration is for family and friends — thank you for understanding.',
        ],
    },
};

export function statusMeta(status) {
    return {
        draft: { key: 'status.draft', dot: 'bg-amber-500', classes: 'bg-amber-50 text-amber-800 border-amber-200' },
        published: { key: 'status.published', dot: 'bg-emerald-500', classes: 'bg-emerald-50 text-emerald-800 border-emerald-200' },
        unpublished: { key: 'status.unpublished', dot: 'bg-stone-400', classes: 'bg-stone-100 text-stone-600 border-stone-200' },
    }[status] ?? { key: 'status.draft', dot: 'bg-amber-500', classes: 'bg-amber-50 text-amber-800 border-amber-200' };
}

export { templates };
