<?php

namespace App\Http\Middleware;

use App\Common\Constant;
use App\Http\Controllers\Common\RequestCommon;
use App\Models\LoginAccountTable;
use App\Models\UserTokenTable;
use Illuminate\Support\Facades\Log;
use Closure;

class CheckAuth
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
        return route('/');
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $request->offsetSet('error_message', null);
            if ($this->whenUserHaveRegistered($request)) {
                // get login info from request/session and validate
                $userId = (isset($request->user_id) && !empty($request->user_id)) ? $request->user_id : session()->get('login.user_id');
                $authType = session()->get('login.auth_type');
                $userToken = session()->get('login.user_token');
                $now = date('Y-m-d H:i:s');

                $userData = LoginAccountTable::getInstance()->where('id', $userId)->first();
                $checkData = UserTokenTable::getInstance()->where([
                    'user_id' => $userId,
                    'auth_type' => $authType,
                    'token' => $userToken,
                    'device_id' => 'web',
                    'os_type' => 'web'])
                    ->whereNull('delete_date')
                    ->first();

                if (empty($checkData)) { // unauthorized
                    session()->forget('login.user_id');
                    session()->forget('login.auth_type');
                    session()->forget('login.user_token');

                    $request->offsetSet('error_message', 'UNAUTHORIZED');
                    return $this->redirectTo($request);
                }
                if ($checkData->expired_time < $now) { // token expired
                    session()->forget('login.user_id');
                    session()->forget('login.auth_type');
                    session()->forget('login.user_token');

                    $request->offsetSet('error_message', 'EXPIRED_TOKEN');
                    return $this->redirectTo($request);
                }

                $request->offsetSet('user_id', $userId);
                $request->offsetSet('auth_type', $authType);
                $request->offsetSet('first_name', $userData->first_name);
                $request->offsetSet('last_name', $userData->last_name);
            }

//            return next($request);
            return $next($request);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            $request->offsetSet('error_message', $exception->getMessage());
            return $this->redirectTo($request);
        }
    }
}
