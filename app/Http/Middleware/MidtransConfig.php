<?php

namespace App\Http\Middleware;

use Closure;
use Midtrans\Config;

class MidtransConfig
{
    public function handle($request, Closure $next)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        return $next($request);
    }
}
