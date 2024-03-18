<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => ':attribute ต้องเป็นวันถัดไปจาก :date',
    'after_or_equal' => ':attribute ต้องเป็นวันเดียวกันหรือวันถัดไปจาก :date',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => ':attribute ต้องอยู่ในรูปแบบของ array',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min ถึง :max. ตัว',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => ':attribute มีค่า true หรือ false เท่านั้น',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => ':attribute ต้องเป็นวันที่เท่านั้น',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => ':attribute ต้องมี :digits ตัว',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => ':attribute ต้องไม่ซ้ำกัน',
    'email' => ':attribute ต้องอยู่ในรูปแบบของ email',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'ข้อมูล :attribute ไม่ถูกต้อง',
    'file' => ':attribute ต้องเป็นไฟล์เท่านั้น',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => ':attribute ต้องมีค่ามากกว่า :value',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute ต้องมากกว่าหรือเท่ากับ :value',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'ข้อมูล :attribute ไม่ถูกต้อง',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute ต้องเป็นตัวเลข',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => ':attribute ต้องน้อยกว่า :value',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => ':attribute ต้องน้อยกว่า :value',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => ':attribute ต้องไม่เกิน :max',
        'file' => ':attribute ต้องมีขนาดไม่เกิน :max KB.',
        'string' => ':attribute ต้องมีตัวอักษรไม่เกิน :max ตัว',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'ไฟล์:attributeต้องเป็นไฟล์ประเภท :values เท่านั้น',
    // 'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute ต้องไม่น้อยกว่า :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute ต้องไม่น้อยกว่า :min ตัว',
        'array' => ':attribute ต้องไม่น้อยกว่า :min',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => ' :attribute ไม่ถูกต้อง.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute ต้องเป็นตัวเลขเท่านั้น',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'กรุณากรอก :attribute',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'กรุณากรอก :attribute',
    'required_unless' => 'กรุณากรอก :attribute',
    'required_with' => 'กรุณากรอก :attribute เมื่อระบุ :values',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => ':attribute ต้องเป็นตัวอักษรเท่านั้น',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => ':attribute มีอยู่แล้วในระบบ',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute must be a valid URL.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
