<?php

namespace App\Services;

use App\Models\WeddingInvitation;
use Illuminate\Support\Str;

class InvitationSlug
{
    /**
     * A small Arabic-to-Latin transliterator so Arabic-only invitations still
     * receive readable, shareable English slugs.
     */
    private const ARABIC_MAP = [
        'ا' => 'a', 'أ' => 'a', 'إ' => 'e', 'آ' => 'aa', 'ب' => 'b', 'ت' => 't',
        'ث' => 'th', 'ج' => 'j', 'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'dh',
        'ر' => 'r', 'ز' => 'z', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd',
        'ط' => 't', 'ظ' => 'z', 'ع' => 'a', 'غ' => 'gh', 'ف' => 'f', 'ق' => 'q',
        'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n', 'ه' => 'h', 'و' => 'w',
        'ي' => 'y', 'ى' => 'a', 'ة' => 'a', 'ء' => '', 'ئ' => 'e', 'ؤ' => 'o',
        'ﻻ' => 'la',
    ];

    public function build(?string $groom, ?string $bride, ?string $groomAr = null, ?string $brideAr = null): string
    {
        $base = $this->transliterate((string) ($groom ?: $groomAr));
        $second = $this->transliterate((string) ($bride ?: $brideAr));

        $parts = array_values(array_filter([$base, $second]));
        $slug = Str::limit(implode('-', $parts), 70, '');

        if ($slug === '') {
            $slug = 'wedding-'.Str::lower(Str::random(6));
        }

        return $this->unique($slug);
    }

    public function unique(string $slug, ?int $ignoreId = null): string
    {
        $slug = trim($slug, '-');
        $slug = $slug !== '' ? $slug : 'wedding';
        $base = $slug;
        $counter = 2;

        while ($this->exists($slug, $ignoreId) || in_array($slug, config('invitations.reserved_slugs', []), true)) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function exists(string $slug, ?int $ignoreId): bool
    {
        return WeddingInvitation::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists();
    }

    private function transliterate(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        $value = strtr($value, self::ARABIC_MAP);

        return Str::slug($value);
    }
}
