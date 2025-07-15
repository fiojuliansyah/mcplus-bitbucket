<?php
// config/cloudinary.php

return [
    'cloud' => [
        'cloud_name' => 'dvtnwsojr',
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ],

    'url' => [
        'secure' => env('CLOUDINARY_SECURE', true),
    ],

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
];
