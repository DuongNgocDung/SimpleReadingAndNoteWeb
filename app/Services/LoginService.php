<?php

namespace App\Services;

use App\Models\LoginAccountTable;
use App\Models\UserTokenTable;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService
{
    /**
     * check login info and save data to session
     * @param $loginId
     * @param $password
     * @return integer | bool
     */
    public function handleLogin($loginId, $password, $deviceId, $osType)
    {
        /** check if login_id and password exist in db */
        $user = LoginAccountTable::getInstance()->getAccountLoginData($loginId, $password);
        if (empty($user)) return false;

        /** generate token for user and save to db*/
        $userToken = $this->saveToken($user->id, $user->auth_type, $deviceId, $osType);

        /** save token login to session */
        session()->put('login.user_id', $user->id);
        session()->put('login.auth_type', $user->auth_type);
        session()->put('login.user_token', $userToken);

        return $user->id;
    }

    public function handleLogout($userId)
    {
        session()->forget('login.user_id');
        session()->forget('login.auth_type');
        session()->forget('login.user_token');

        UserTokenTable::getInstance()->where(['user_id' => $userId, 'device_id' => 'web', 'os_type' => 'web'])->delete();
    }

    /**
     * @param $userId
     * @param $authType
     * @param $deviceId
     * @param $osType
     * @return string|null
     */
    public function saveToken($userId, $authType, $deviceId, $osType)
    {
        try {
            $now = date('Y-m-d H:i:s');
            $next5YearsTimestamp = strtotime('+5 year');
            $expiredTimeAfter5Years = date('Y-m-d H:i:s', $next5YearsTimestamp);
            $token = null;

            // TODO: what is jwt auth
            try {
                $payload = JWTFactory::customClaims(
                    [
                        'sub' => 'nd_again_app',
                        'id'  => $userId,
                        'exp' => $next5YearsTimestamp,
                    ]
                )->make();
                $token = JWTAuth::encode($payload)->get();
            } catch (JWTException $JWTException) {
                Log::error($JWTException->getMessage());
                return null;
            }

            UserTokenTable::getInstance()->updateOrInsert([
                'user_id'   => $userId,
                'auth_type' => $authType,
                'device_id' => $deviceId,
                'os_type'   => $osType
            ], [
                'user_id'       => $userId,
                'auth_type'     => $authType,
                'device_id'     => $deviceId,
                'os_type'       => $osType,
                'token'         => $token,
                'expired_time'  => $expiredTimeAfter5Years,
                'register_date' => $now,
                'delete_date'   => null,
            ]);

            return $token;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }
}
