<?php

namespace App\Http\Middleware;

use App\Common\Constant;
use App\Http\Controllers\Common\RequestCommon;
use App\Models\UserTokenTable;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;

class Authenticate extends Middleware
{
    use RequestCommon;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        return route('/');
    }

    public function handle($request)
    {
        return route('/');
    }
}
