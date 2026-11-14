<?php

namespace App\Http\Controllers;

use App\Http\Resources\WeddingInvitationResource;
use App\Models\WeddingInvitation;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PublicInvitationController extends Controller
{
    public function show(string $slug): InertiaResponse
    {
        $invitation = WeddingInvitation::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $invitation->increment('views_count');

        $events = $invitation->event_details ?? [];
        $groom = $invitation->groom_name_ar;
        $bride = $invitation->bride_name_ar;
        $venue = $events['venue_name_ar'] ?? null;
        $date = $events['wedding_date'] ?? null;

        $descriptionParts = array_filter([
            'دعوة زفاف '.$groom.' و'.$bride,
            $date ? ' بتاريخ '.$date : null,
            $venue ? ' في '.$venue : null,
            '— شاركوا فرحتهم بحضوركم.',
        ]);

        $cover = $invitation->cover_image_path
            ? url(Storage::disk('public')->url($invitation->cover_image_path))
            : null;

        $meta = [
            'title' => 'دعوة زفاف '.$groom.' و'.$bride.' | '.config('app.name'),
            'description' => implode(' ', $descriptionParts),
            'image' => $cover,
            'url' => route('invitations.public', $invitation->slug),
            'locale' => 'ar_AR',
            'alternate_locale' => 'en_US',
        ];

        return Inertia::render('Public/Show', [
            'invitation' => (new WeddingInvitationResource($invitation))->resolve(),
            'meta' => $meta,
        ]);
    }

    public function calendar(string $slug): Response
    {
        $invitation = WeddingInvitation::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $start = $invitation->eventStart();
        abort_if($start === null, 404);

        $events = $invitation->event_details ?? [];
        $end = $start->addHours(4);

        $summary = 'حفل زفاف '.$invitation->groom_name_ar.' و'.$invitation->bride_name_ar;
        $venue = trim(implode(' — ', array_filter([
            $events['venue_name_ar'] ?? null,
            $events['venue_address_ar'] ?? null,
        ])));

        $description = trim(implode("\n", array_filter([
            $invitation->invitation_content['message_ar'] ?? null,
            $invitation->invitation_content['closing_ar'] ?? null,
            $invitation->cover_image_path
                ? url(Storage::disk('public')->url($invitation->cover_image_path))
                : null,
        ])));

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//'.config('app.name').'//Wedding Invitation//AR',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:'.$invitation->slug.'@'.parse_url(config('app.url'), PHP_URL_HOST),
            'DTSTAMP:'.now()->utc()->format('Ymd\THis\Z'),
            'DTSTART:'.$start->utc()->format('Ymd\THis\Z'),
            'DTEND:'.$end->utc()->format('Ymd\THis\Z'),
            'SUMMARY:'.$this->escape($summary),
            'LOCATION:'.$this->escape($venue),
            'DESCRIPTION:'.$this->escape($description),
            'URL:'.route('invitations.public', $invitation->slug),
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return response(implode("\r\n", $lines)."\r\n", 200, [
            'Content-Type' => 'text/calendar; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$invitation->slug.'.ics"',
        ]);
    }

    private function escape(string $value): string
    {
        $value = str_replace(["\r\n", "\n", "\r"], '\\n', $value);
        $value = str_replace(['\\', ';', ','], ['\\\\', '\\;', '\\,'], $value);

        return trim($value);
    }
}
