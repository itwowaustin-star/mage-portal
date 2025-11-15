<?php

return [
    'media_base_url' => env('PORTAL_MEDIA_BASE_URL', env('APP_ASSET_URL', env('APP_URL'))),
    'local_disk' => env('PORTAL_LOCAL_DISK', 'public'),
    'local_path_prefix' => env('PORTAL_LOCAL_PATH', 'portal-media'),
];
