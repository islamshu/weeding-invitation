<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WeddingInvitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeddingInvitation>
 */
class WeddingInvitationFactory extends Factory
{
    protected $model = WeddingInvitation::class;

    public function definition(): array
    {
        $groom = $this->faker->randomElement(['أحمد', 'محمد', 'خالد', 'يوسف', 'عمر', 'محمود', 'سامي']);
        $bride = $this->faker->randomElement(['سارة', 'لينا', 'نور', 'رنا', 'مريم', 'هبة', 'دينا']);
        $date = now()->addMonths($this->faker->numberBetween(2, 10))->startOfMonth();

        return [
            'user_id' => User::factory(),
            'slug' => 'wedding-'.strtolower($this->faker->unique()->bothify('????-####')),
            'enable_english' => false,
            'groom_name_ar' => $groom.' عبد الله',
            'groom_name_en' => null,
            'bride_name_ar' => $bride.' محمود',
            'bride_name_en' => null,
            'couple_note_ar' => null,
            'couple_note_en' => null,
            'groom_wakil' => [
                'title_key' => 'engineer',
                'title_custom_ar' => null,
                'title_custom_en' => null,
                'name_ar' => 'أكرم عبد المعطي',
                'name_en' => null,
                'kunya_ar' => 'أبو أحمد',
                'kunya_en' => null,
                'designation_key' => 'groom_father',
                'designation_custom_ar' => null,
                'designation_custom_en' => null,
                'intro_ar' => null,
                'intro_en' => null,
                'show_title' => true,
                'show_name' => true,
                'show_kunya' => true,
                'show_designation' => true,
            ],
            'bride_wakil' => [
                'title_key' => 'mr',
                'title_custom_ar' => null,
                'title_custom_en' => null,
                'name_ar' => 'خالد فتحي سلامة',
                'name_en' => null,
                'kunya_ar' => 'أبو فتحي',
                'kunya_en' => null,
                'designation_key' => 'bride_father',
                'designation_custom_ar' => null,
                'designation_custom_en' => null,
                'intro_ar' => null,
                'intro_en' => null,
                'show_title' => true,
                'show_name' => true,
                'show_kunya' => true,
                'show_designation' => true,
            ],
            'invitation_content' => [
                'title_ar' => 'دعوة زفاف',
                'title_en' => null,
                'intro_ar' => 'بكل محبة وفرح، نتشرف بدعوتكم لمشاركتنا فرحة العمر.',
                'intro_en' => null,
                'message_ar' => 'يسرنا ويشرفنا دعوتكم لحضور حفل زفافنا، سائلين الله أن يجمعنا على الخير والمحبة.',
                'message_en' => null,
                'religious_ar' => '﴿وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَاجًا لِّتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً﴾',
                'religious_en' => null,
                'closing_ar' => 'حضوركم شرف لنا ويضيف لفرحتنا بهجة.',
                'closing_en' => null,
                'additional_ar' => null,
                'additional_en' => null,
            ],
            'event_details' => [
                'wedding_date' => $date->format('Y-m-d'),
                'wedding_time' => '18:30',
                'venue_name_ar' => 'قاعة الياسمين',
                'venue_name_en' => null,
                'venue_address_ar' => 'رام الله — شارع الإرسال',
                'venue_address_en' => null,
                'maps_url' => 'https://maps.google.com/?q=Ramallah',
                'henna_enabled' => false,
                'henna_date' => null,
                'henna_time' => null,
                'henna_location_ar' => null,
                'henna_location_en' => null,
                'reception_enabled' => false,
                'reception_date' => null,
                'reception_time' => null,
                'reception_location_ar' => null,
                'reception_location_en' => null,
            ],
            'design_settings' => config('invitations.default_design'),
            'template_key' => $this->faker->randomElement(array_keys(config('invitations.templates'))),
            'status' => WeddingInvitation::STATUS_DRAFT,
            'published_at' => null,
            'views_count' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => WeddingInvitation::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn () => [
            'status' => WeddingInvitation::STATUS_UNPUBLISHED,
            'published_at' => now()->subDays(4),
        ]);
    }
}
