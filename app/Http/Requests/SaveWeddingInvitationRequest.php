<?php

namespace App\Http\Requests;

use App\Models\WeddingInvitation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveWeddingInvitationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $invitation = $this->route('invitation');

        if ($invitation instanceof WeddingInvitation) {
            return $this->user()?->can('update', $invitation) ?? false;
        }

        return (bool) $this->user();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'enable_english' => $this->boolean('enable_english'),
            'slug' => $this->filled('slug') ? strtolower(trim((string) $this->input('slug'))) : null,
            'groom_wakil' => $this->normalizeWakil($this->input('groom_wakil')),
            'bride_wakil' => $this->normalizeWakil($this->input('bride_wakil')),
            'event_details' => $this->normalizeEvents((array) $this->input('event_details', [])),
            'design_settings' => $this->normalizeDesign((array) $this->input('design_settings', [])),
        ]);
    }

    public function rules(): array
    {
        $publishing = $this->isPublishing();
        $invitation = $this->route('invitation');
        $ignoreId = $invitation instanceof WeddingInvitation ? $invitation->id : null;

        $required = $publishing ? 'required' : 'required';
        $requiredToPublish = $publishing ? 'required' : 'nullable';

        return [
            'intent' => ['nullable', Rule::in(['save', 'publish'])],
            'return_step' => ['nullable', 'integer', 'between:1,6'],
            'slug' => [
                'nullable', 'string', 'max:90', 'alpha_dash',
                Rule::notIn(config('invitations.reserved_slugs', [])),
                Rule::unique('wedding_invitations', 'slug')->ignore($ignoreId),
            ],
            'enable_english' => ['boolean'],

            'groom_name_ar' => [$required, 'string', 'max:120'],
            'groom_name_en' => ['nullable', 'string', 'max:120'],
            'bride_name_ar' => [$required, 'string', 'max:120'],
            'bride_name_en' => ['nullable', 'string', 'max:120'],
            'couple_note_ar' => ['nullable', 'string', 'max:255'],
            'couple_note_en' => ['nullable', 'string', 'max:255'],

            'groom_wakil' => ['nullable', 'array'],
            'groom_wakil.title_key' => ['nullable', 'string', Rule::in(array_keys(config('invitations.title_keys', [])))],
            'groom_wakil.title_custom_ar' => ['nullable', 'string', 'max:80'],
            'groom_wakil.title_custom_en' => ['nullable', 'string', 'max:80'],
            'groom_wakil.name_ar' => ['nullable', 'string', 'max:160'],
            'groom_wakil.name_en' => ['nullable', 'string', 'max:160'],
            'groom_wakil.kunya_ar' => ['nullable', 'string', 'max:100'],
            'groom_wakil.kunya_en' => ['nullable', 'string', 'max:100'],
            'groom_wakil.designation_key' => ['nullable', 'string', Rule::in(array_keys(config('invitations.designation_keys', [])))],
            'groom_wakil.designation_custom_ar' => ['nullable', 'string', 'max:120'],
            'groom_wakil.designation_custom_en' => ['nullable', 'string', 'max:120'],
            'groom_wakil.intro_ar' => ['nullable', 'string', 'max:300'],
            'groom_wakil.intro_en' => ['nullable', 'string', 'max:300'],
            'groom_wakil.show_title' => ['boolean'],
            'groom_wakil.show_name' => ['boolean'],
            'groom_wakil.show_kunya' => ['boolean'],
            'groom_wakil.show_designation' => ['boolean'],

            'bride_wakil' => ['nullable', 'array'],
            'bride_wakil.title_key' => ['nullable', 'string', Rule::in(array_keys(config('invitations.title_keys', [])))],
            'bride_wakil.title_custom_ar' => ['nullable', 'string', 'max:80'],
            'bride_wakil.title_custom_en' => ['nullable', 'string', 'max:80'],
            'bride_wakil.name_ar' => ['nullable', 'string', 'max:160'],
            'bride_wakil.name_en' => ['nullable', 'string', 'max:160'],
            'bride_wakil.kunya_ar' => ['nullable', 'string', 'max:100'],
            'bride_wakil.kunya_en' => ['nullable', 'string', 'max:100'],
            'bride_wakil.designation_key' => ['nullable', 'string', Rule::in(array_keys(config('invitations.designation_keys', [])))],
            'bride_wakil.designation_custom_ar' => ['nullable', 'string', 'max:120'],
            'bride_wakil.designation_custom_en' => ['nullable', 'string', 'max:120'],
            'bride_wakil.intro_ar' => ['nullable', 'string', 'max:300'],
            'bride_wakil.intro_en' => ['nullable', 'string', 'max:300'],
            'bride_wakil.show_title' => ['boolean'],
            'bride_wakil.show_name' => ['boolean'],
            'bride_wakil.show_kunya' => ['boolean'],
            'bride_wakil.show_designation' => ['boolean'],

            'invitation_content' => ['nullable', 'array'],
            'invitation_content.title_ar' => ['nullable', 'string', 'max:160'],
            'invitation_content.title_en' => ['nullable', 'string', 'max:160'],
            'invitation_content.invite_line_ar' => ['nullable', 'string', 'max:300'],
            'invitation_content.invite_line_en' => ['nullable', 'string', 'max:300'],
            'invitation_content.intro_ar' => ['nullable', 'string', 'max:700'],
            'invitation_content.intro_en' => ['nullable', 'string', 'max:700'],
            'invitation_content.message_ar' => ['nullable', 'string', 'max:1500'],
            'invitation_content.message_en' => ['nullable', 'string', 'max:1500'],
            'invitation_content.religious_ar' => ['nullable', 'string', 'max:700'],
            'invitation_content.religious_en' => ['nullable', 'string', 'max:700'],
            'invitation_content.closing_ar' => ['nullable', 'string', 'max:700'],
            'invitation_content.closing_en' => ['nullable', 'string', 'max:700'],
            'invitation_content.additional_ar' => ['nullable', 'string', 'max:700'],
            'invitation_content.additional_en' => ['nullable', 'string', 'max:700'],

            'event_details' => [$publishing ? 'required' : 'nullable', 'array'],
            'event_details.wedding_date' => [$requiredToPublish, 'date_format:Y-m-d'],
            'event_details.wedding_time' => [$requiredToPublish, 'date_format:H:i'],
            'event_details.venue_name_ar' => [$requiredToPublish, 'string', 'max:180'],
            'event_details.venue_name_en' => ['nullable', 'string', 'max:180'],
            'event_details.venue_address_ar' => ['nullable', 'string', 'max:300'],
            'event_details.venue_address_en' => ['nullable', 'string', 'max:300'],
            'event_details.maps_url' => ['nullable', 'url', 'max:600'],
            'event_details.henna_enabled' => ['boolean'],
            'event_details.henna_date' => ['nullable', 'date_format:Y-m-d'],
            'event_details.henna_time' => ['nullable', 'date_format:H:i'],
            'event_details.henna_location_ar' => ['nullable', 'string', 'max:180'],
            'event_details.henna_location_en' => ['nullable', 'string', 'max:180'],
            'event_details.reception_enabled' => ['boolean'],
            'event_details.reception_date' => ['nullable', 'date_format:Y-m-d'],
            'event_details.reception_time' => ['nullable', 'date_format:H:i'],
            'event_details.reception_location_ar' => ['nullable', 'string', 'max:180'],
            'event_details.reception_location_en' => ['nullable', 'string', 'max:180'],

            'design_settings' => ['nullable', 'array'],
            'design_settings.preset' => ['nullable', 'string', 'max:40'],
            'design_settings.primary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'design_settings.secondary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'design_settings.background_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'design_settings.text_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'design_settings.decorative_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'design_settings.font_family' => ['nullable', Rule::in(['auto', 'cairo', 'tajawal', 'naskh', 'playfair', 'cormorant', 'montserrat'])],
            'design_settings.background_style' => ['nullable', Rule::in(['soft', 'plain', 'paper', 'texture', 'image'])],
            'design_settings.border_style' => ['nullable', Rule::in(['ornate', 'thin', 'double', 'none'])],
            'design_settings.envelope_style' => ['nullable', Rule::in(config('invitations.envelope_styles', []))],
            'design_settings.couple_layout' => ['nullable', Rule::in(['groom_right', 'groom_left'])],
            'design_settings.show_centerpiece' => ['boolean'],
            'design_settings.show_florals' => ['boolean'],
            'design_settings.show_monogram' => ['boolean'],
            'design_settings.show_hearts' => ['boolean'],
            'design_settings.effects' => ['nullable', 'array'],
            'design_settings.effects.petals' => ['boolean'],
            'design_settings.effects.sparkles' => ['boolean'],
            'design_settings.effects.confetti' => ['boolean'],

            'template_key' => [$publishing ? 'required' : 'nullable', Rule::in(array_keys(config('invitations.templates', [])))],

            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'background_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'decorative_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_cover_image' => ['boolean'],
            'remove_background_image' => ['boolean'],
            'remove_decorative_image' => ['boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $events = (array) $this->input('event_details', []);

            if (! empty($events['henna_enabled']) && empty($events['henna_date'])) {
                $validator->errors()->add('event_details.henna_date', __('validation.required', ['attribute' => __('fields.henna_date')]));
            }

            if (! empty($events['reception_enabled']) && empty($events['reception_date'])) {
                $validator->errors()->add('event_details.reception_date', __('validation.required', ['attribute' => __('fields.reception_date')]));
            }
        });
    }

    public function isPublishing(): bool
    {
        return $this->input('intent') === 'publish';
    }

    protected function normalizeWakil(mixed $wakil): array
    {
        $wakil = (array) ($wakil ?: []);

        return [
            'title_key' => $wakil['title_key'] ?? 'none',
            'title_custom_ar' => $wakil['title_custom_ar'] ?? null,
            'title_custom_en' => $wakil['title_custom_en'] ?? null,
            'name_ar' => $wakil['name_ar'] ?? null,
            'name_en' => $wakil['name_en'] ?? null,
            'kunya_ar' => $wakil['kunya_ar'] ?? null,
            'kunya_en' => $wakil['kunya_en'] ?? null,
            'designation_key' => $wakil['designation_key'] ?? 'none',
            'designation_custom_ar' => $wakil['designation_custom_ar'] ?? null,
            'designation_custom_en' => $wakil['designation_custom_en'] ?? null,
            'intro_ar' => $wakil['intro_ar'] ?? null,
            'intro_en' => $wakil['intro_en'] ?? null,
            'show_title' => filter_var($wakil['show_title'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_name' => filter_var($wakil['show_name'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_kunya' => filter_var($wakil['show_kunya'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_designation' => filter_var($wakil['show_designation'] ?? true, FILTER_VALIDATE_BOOLEAN),
        ];
    }

    protected function normalizeEvents(array $events): array
    {
        return [
            'wedding_date' => $events['wedding_date'] ?? null,
            'wedding_time' => $events['wedding_time'] ?? null,
            'venue_name_ar' => $events['venue_name_ar'] ?? null,
            'venue_name_en' => $events['venue_name_en'] ?? null,
            'venue_address_ar' => $events['venue_address_ar'] ?? null,
            'venue_address_en' => $events['venue_address_en'] ?? null,
            'maps_url' => $events['maps_url'] ?? null,
            'henna_enabled' => filter_var($events['henna_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'henna_date' => $events['henna_date'] ?? null,
            'henna_time' => $events['henna_time'] ?? null,
            'henna_location_ar' => $events['henna_location_ar'] ?? null,
            'henna_location_en' => $events['henna_location_en'] ?? null,
            'reception_enabled' => filter_var($events['reception_enabled'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'reception_date' => $events['reception_date'] ?? null,
            'reception_time' => $events['reception_time'] ?? null,
            'reception_location_ar' => $events['reception_location_ar'] ?? null,
            'reception_location_en' => $events['reception_location_en'] ?? null,
        ];
    }

    protected function normalizeDesign(array $design): array
    {
        $defaults = config('invitations.default_design', []);
        $effects = (array) ($design['effects'] ?? []);

        $colors = ['primary_color', 'secondary_color', 'background_color', 'text_color', 'decorative_color'];
        foreach ($colors as $color) {
            $design[$color] = $design[$color] ?? $defaults[$color] ?? null;
        }

        return [
            'preset' => $design['preset'] ?? $defaults['preset'],
            'primary_color' => $design['primary_color'],
            'secondary_color' => $design['secondary_color'],
            'background_color' => $design['background_color'],
            'text_color' => $design['text_color'],
            'decorative_color' => $design['decorative_color'],
            'font_family' => $design['font_family'] ?? $defaults['font_family'],
            'background_style' => $design['background_style'] ?? $defaults['background_style'],
            'border_style' => $design['border_style'] ?? $defaults['border_style'],
            'envelope_style' => $design['envelope_style'] ?? $defaults['envelope_style'],
            'couple_layout' => $design['couple_layout'] ?? $defaults['couple_layout'],
            'show_centerpiece' => filter_var($design['show_centerpiece'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_florals' => filter_var($design['show_florals'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_monogram' => filter_var($design['show_monogram'] ?? true, FILTER_VALIDATE_BOOLEAN),
            'show_hearts' => filter_var($design['show_hearts'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'effects' => [
                'petals' => filter_var($effects['petals'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'sparkles' => filter_var($effects['sparkles'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'confetti' => filter_var($effects['confetti'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ],
        ];
    }
}
