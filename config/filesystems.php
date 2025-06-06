<?php

use Illuminate\Support\Facades\Storage;

return [

    'default' => env('FILESYSTEM_DISK', 'local'),

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

       's3' => [
    'driver' => 's3',
    'key' => env('SUPABASE_STORAGE_KEY'),
    'secret' => env('SUPABASE_STORAGE_SECRET'),
    'region' => env('SUPABASE_STORAGE_REGION'),
    'bucket' => env('SUPABASE_STORAGE_BUCKET'),
    'endpoint' => env('SUPABASE_STORAGE_ENDPOINT'),
    'use_path_style_endpoint' => true,
    'visibility' => 'public',
],

    ],

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];