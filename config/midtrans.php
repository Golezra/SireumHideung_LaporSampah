<?php
return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-SB-Mid-server-teoI7RpLhSjpuKY8BAaI02IF'),
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-nCwj1JfOa0EuMkFK'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];

\Log::info('Server Key: ' . config('services.midtrans.server_key'));
\Log::info('Client Key: ' . config('services.midtrans.client_key'));