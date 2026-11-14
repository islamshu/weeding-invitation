<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class WeddingInvitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $eventDetails = $this->event_details ?? [];

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'status' => $this->status,
            'enable_english' => (bool) $this->enable_english,
            'template_key' => $this->template_key,
            'groom_name_ar' => $this->groom_name_ar,
            'groom_name_en' => $this->groom_name_en,
            'bride_name_ar' => $this->bride_name_ar,
            'bride_name_en' => $this->bride_name_en,
            'couple_note_ar' => $this->couple_note_ar,
            'couple_note_en' => $this->couple_note_en,
            'groom_wakil' => $this->groom_wakil ?? [],
            'bride_wakil' => $this->bride_wakil ?? [],
            'invitation_content' => $this->invitation_content ?? [],
            'event_details' => $eventDetails,
            'design_settings' => $this->designSettings(),
            'event_start_iso' => $this->eventStartIso(),
            'published_at' => $this->published_at?->toIso8601String(),
            'views_count' => $this->views_count,
            'cover_image_url' => $this->imageUrl($this->cover_image_path),
            'background_image_url' => $this->imageUrl($this->background_image_path),
            'decorative_image_url' => $this->imageUrl($this->decorative_image_path),
            'public_url' => $this->isPublished() ? route('invitations.public', $this->slug) : null,
            'calendar_url' => $this->isPublished() ? route('invitations.calendar', $this->slug) : null,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    private function imageUrl(?string $path): ?string
    {
        return $path ? Storage::disk('public')->url($path) : null;
    }
}
