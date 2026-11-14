<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Public invitation timezone
    |--------------------------------------------------------------------------
    | Wedding dates are entered as local date/time values. This timezone is
    | used to build the calendar feed and the countdown target.
    */
    'timezone' => env('INVITATION_TIMEZONE', 'Asia/Jerusalem'),

    /*
    |--------------------------------------------------------------------------
    | Template catalogue
    |--------------------------------------------------------------------------
    | Keys are validated server-side. Visual definitions live in the frontend
    | template registry (resources/js/data/templates.js).
    */
    'templates' => [
        'classic_royal' => ['name_ar' => 'الملكي الكلاسيكي', 'name_en' => 'Classic Royal', 'category' => 'classic'],
        'minimalist_ivory' => ['name_ar' => 'العاجي البسيط', 'name_en' => 'Minimalist Ivory', 'category' => 'minimal'],
        'romantic_floral' => ['name_ar' => 'الزهور الرومانسية', 'name_en' => 'Romantic Floral', 'category' => 'floral'],
        'black_gold' => ['name_ar' => 'الأسود والذهب', 'name_en' => 'Black & Gold', 'category' => 'luxury'],
        'modern_beige' => ['name_ar' => 'البيج العصري', 'name_en' => 'Modern Beige', 'category' => 'modern'],
        'white_silver' => ['name_ar' => 'الأبيض والفضي', 'name_en' => 'White & Silver', 'category' => 'minimal'],
        'traditional_palestinian' => ['name_ar' => 'الفلسطيني التقليدي', 'name_en' => 'Traditional Palestinian', 'category' => 'heritage'],
        'botanical_green' => ['name_ar' => 'الأخضر النباتي', 'name_en' => 'Botanical Green', 'category' => 'floral'],
        'burgundy_luxury' => ['name_ar' => 'العنابي الفاخر', 'name_en' => 'Burgundy Luxury', 'category' => 'luxury'],
        'pink_romance' => ['name_ar' => 'الوردي الرومانسي', 'name_en' => 'Pink Romance', 'category' => 'romantic'],
        'modern_editorial' => ['name_ar' => 'التحريري الحديث', 'name_en' => 'Modern Editorial', 'category' => 'modern'],
        'emerald_royal' => ['name_ar' => 'الزمردي الملكي', 'name_en' => 'Emerald Royal', 'category' => 'heritage'],
    ],

    'categories' => [
        'classic' => 'كلاسيكي',
        'minimal' => 'بسيط',
        'floral' => 'زهري',
        'luxury' => 'فاخر',
        'heritage' => 'تراثي',
        'romantic' => 'رومانسي',
        'modern' => 'عصري',
    ],

    'default_design' => [
        'preset' => 'champagne',
        'primary_color' => '#8a6a3b',
        'secondary_color' => '#c9a86a',
        'background_color' => '#fbf7f0',
        'text_color' => '#2f2a24',
        'decorative_color' => '#c9a86a',
        'font_family' => 'auto',
        'background_style' => 'soft',
        'border_style' => 'ornate',
        'envelope_style' => 'classic',
        'couple_layout' => 'groom_right',
        'show_centerpiece' => true,
        'show_florals' => true,
        'show_monogram' => true,
        'show_hearts' => false,
        'effects' => [
            'petals' => false,
            'sparkles' => false,
            'confetti' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Envelope catalogue
    |--------------------------------------------------------------------------
    | Keep this list in sync with resources/js/data/envelopeStyles.js.
    */
    'envelope_styles' => [
        'classic', 'wax', 'monogram', 'floral', 'minimal',
        'arabesque', 'deco', 'ribbon', 'night',
    ],

    'title_keys' => [
        'none' => ['ar' => '', 'en' => ''],
        'mr' => ['ar' => 'السيد', 'en' => 'Mr.'],
        'engineer' => ['ar' => 'المهندس', 'en' => 'Eng.'],
        'doctor' => ['ar' => 'الدكتور', 'en' => 'Dr.'],
        'hajj' => ['ar' => 'الحاج', 'en' => 'Hajj'],
        'sheikh' => ['ar' => 'الشيخ', 'en' => 'Sheikh'],
        'professor' => ['ar' => 'الأستاذ', 'en' => 'Mr.'], // "الأستاذ" has no exact English honorific
        'custom' => ['ar' => '', 'en' => ''],
    ],

    'designation_keys' => [
        'none' => ['ar' => '', 'en' => ''],
        'groom_father' => ['ar' => 'والد العريس', 'en' => 'Father of the Groom'],
        'bride_father' => ['ar' => 'والد العروس', 'en' => 'Father of the Bride'],
        'groom_brother' => ['ar' => 'أخ العريس', 'en' => 'Brother of the Groom'],
        'bride_brother' => ['ar' => 'أخ العروس', 'en' => 'Brother of the Bride'],
        'groom_uncle' => ['ar' => 'عم العريس', 'en' => "Groom's Uncle"],
        'bride_uncle' => ['ar' => 'عم العروس', 'en' => "Bride's Uncle"],
        'sons_of_deceased' => ['ar' => 'أبناء المرحوم', 'en' => 'Sons of the late'],
        'family_of_deceased' => ['ar' => 'عائلة المرحوم', 'en' => 'Family of the late'],
        'custom' => ['ar' => '', 'en' => ''],
    ],

    'reserved_slugs' => [
        'admin', 'dashboard', 'login', 'register', 'logout', 'invitations',
        'w', 'api', 'preview', 'publish', 'unpublish', 'calendar', 'storage',
    ],
];
