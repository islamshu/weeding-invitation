<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeddingInvitation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demo = User::firstOrCreate(
            ['email' => 'demo@dawati.test'],
            ['name' => 'حساب التجربة', 'password' => Hash::make('password')]
        );

        if ($demo->invitations()->exists()) {
            return;
        }

        $published = WeddingInvitation::factory()
            ->published()
            ->create([
                'user_id' => $demo->id,
                'slug' => 'ahmad-sara-wedding',
                'groom_name_ar' => 'أحمد عبد الله',
                'bride_name_ar' => 'سارة محمود',
                'template_key' => 'traditional_palestinian',
                'views_count' => 128,
            ]);

        $published->forceFill([
            'groom_wakil' => array_replace($published->groom_wakil, [
                'title_key' => 'engineer',
                'name_ar' => 'أكرم عبد المعطي جودة',
                'kunya_ar' => 'أبو أحمد',
                'designation_key' => 'groom_father',
            ]),
            'bride_wakil' => array_replace($published->bride_wakil, [
                'title_key' => 'mr',
                'name_ar' => 'خالد فتحي سلامة',
                'kunya_ar' => 'أبو فتحي',
                'designation_key' => 'bride_father',
            ]),
        ])->save();

        WeddingInvitation::factory()->create([
            'user_id' => $demo->id,
            'slug' => 'kareem-lina-draft',
            'groom_name_ar' => 'كريم يوسف',
            'bride_name_ar' => 'لينا سامي',
            'template_key' => 'romantic_floral',
            'status' => WeddingInvitation::STATUS_DRAFT,
        ]);

        WeddingInvitation::factory()
            ->unpublished()
            ->create([
                'user_id' => $demo->id,
                'slug' => 'omar-noor-archive',
                'groom_name_ar' => 'عمر خالد',
                'bride_name_ar' => 'نور أحمد',
                'template_key' => 'black_gold',
            ]);

        $withEnglish = WeddingInvitation::factory()
            ->published()
            ->create([
                'user_id' => $demo->id,
                'slug' => 'yousef-mariam-wedding',
                'enable_english' => true,
                'groom_name_ar' => 'يوسف محمود',
                'groom_name_en' => 'Yousef Mahmoud',
                'bride_name_ar' => 'مريم خليل',
                'bride_name_en' => 'Mariam Khalil',
                'template_key' => 'emerald_royal',
                'views_count' => 64,
            ]);

        $withEnglish->forceFill([
            'groom_wakil' => array_replace($withEnglish->groom_wakil, [
                'name_en' => 'Akram Abdel Muti',
                'kunya_en' => 'Abu Ahmad',
            ]),
            'bride_wakil' => array_replace($withEnglish->bride_wakil, [
                'name_en' => 'Khaled Fathi Salameh',
                'kunya_en' => 'Abu Fathi',
            ]),
            'invitation_content' => array_replace($withEnglish->invitation_content, [
                'title_en' => 'Wedding Invitation',
                'intro_en' => 'With love and joy, we invite you to share the happiest day of our lives.',
                'message_en' => 'It is our honour to invite you to celebrate our wedding with us.',
                'religious_en' => '“And among His signs is that He created for you mates from among yourselves, that you may dwell in tranquillity with them.”',
                'closing_en' => 'Your presence is our greatest honour.',
            ]),
            'event_details' => array_replace($withEnglish->event_details, [
                'venue_name_en' => 'Al Yasmin Hall',
                'venue_address_en' => 'Ramallah — Al Irsal Street',
            ]),
        ])->save();
    }
}
