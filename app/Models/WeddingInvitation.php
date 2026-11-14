<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingInvitation extends Model
{
    /** @use HasFactory<\Database\Factories\WeddingInvitationFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    public const STATUS_UNPUBLISHED = 'unpublished';

    protected $fillable = [
        'user_id',
        'slug',
        'enable_english',
        'groom_name_ar',
        'groom_name_en',
        'bride_name_ar',
        'bride_name_en',
        'couple_note_ar',
        'couple_note_en',
        'groom_wakil',
        'bride_wakil',
        'invitation_content',
        'event_details',
        'design_settings',
        'template_key',
        'status',
        'published_at',
        'cover_image_path',
        'background_image_path',
        'decorative_image_path',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'enable_english' => 'boolean',
            'groom_wakil' => 'array',
            'bride_wakil' => 'array',
            'invitation_content' => 'array',
            'event_details' => 'array',
            'design_settings' => 'array',
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isUnpublished(): bool
    {
        return $this->status === self::STATUS_UNPUBLISHED;
    }

    public function publish(): void
    {
        $this->forceFill([
            'status' => self::STATUS_PUBLISHED,
            'published_at' => $this->published_at ?? now(),
        ])->save();
    }

    public function unpublish(): void
    {
        $this->forceFill(['status' => self::STATUS_UNPUBLISHED])->save();
    }

    public function designSettings(): array
    {
        $defaults = config('invitations.default_design', []);

        return array_replace_recursive($defaults, $this->design_settings ?? []);
    }

    /**
     * Build a timezone-aware start instant from the stored local date & time.
     */
    public function eventStart(): ?\Carbon\CarbonImmutable
    {
        $details = $this->event_details ?? [];
        $date = $details['wedding_date'] ?? null;

        if (! $date) {
            return null;
        }

        $time = $details['wedding_time'] ?? '18:00';

        try {
            return \Carbon\CarbonImmutable::createFromFormat(
                'Y-m-d H:i',
                $date.' '.substr((string) $time, 0, 5),
                config('invitations.timezone', 'Asia/Jerusalem')
            );
        } catch (\Throwable) {
            return null;
        }
    }

    public function eventStartIso(): ?string
    {
        return $this->eventStart()?->utc()->toIso8601String();
    }
}
