<?php

return [
    'accepted' => 'يجب قبول :attribute.',
    'array' => 'يجب أن يكون :attribute قائمة.',
    'boolean' => 'يجب أن تكون قيمة :attribute صحيحة أو خاطئة.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_format' => ':attribute لا يطابق الصيغة :format.',
    'email' => 'يجب إدخال بريد إلكتروني صحيح.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => ':attribute المحدد غير صالح.',
    'lowercase' => 'يجب أن يكون :attribute بأحرف صغيرة.',
    'max' => [
        'array' => 'يجب ألا تحتوي :attribute على أكثر من :max عنصرًا.',
        'file' => 'يجب ألا يزيد حجم :attribute عن :max كيلوبايت.',
        'numeric' => 'يجب ألا تزيد قيمة :attribute عن :max.',
        'string' => 'يجب ألا يزيد :attribute عن :max حرفًا.',
    ],
    'mimes' => 'يجب أن يكون :attribute ملفًا من نوع: :values.',
    'min' => [
        'array' => 'يجب أن تحتوي :attribute على :min عنصرًا على الأقل.',
        'file' => 'يجب ألا يقل حجم :attribute عن :min كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة :attribute :min على الأقل.',
        'string' => 'يجب أن يكون :attribute :min أحرف على الأقل.',
    ],
    'not_in' => ':attribute المحدد غير متاح.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'password' => [
        'letters' => 'يجب أن يحتوي :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي :attribute على حرف كبير وحرف صغير.',
        'numbers' => 'يجب أن يحتوي :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'ظهر :attribute في تسريب بيانات. الرجاء اختيار :attribute آخر.',
    ],
    'regex' => 'صيغة :attribute غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'unique' => 'قيمة :attribute مستخدمة بالفعل.',
    'uploaded' => 'فشل رفع :attribute.',
    'url' => 'يجب إدخال رابط صحيح لـ :attribute.',

    'custom' => [
        'password' => [
            'min' => 'يجب أن تتكون كلمة المرور من :min أحرف على الأقل.',
        ],
    ],

    'attributes' => require __DIR__.'/fields.php',
];
