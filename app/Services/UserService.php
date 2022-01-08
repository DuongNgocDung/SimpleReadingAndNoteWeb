<?php

namespace App\Services;

use App\Common\Constant;
use App\Models\LoginAccountTable;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * create account and login
     * @param $loginId
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $auth
     * @return integer | null
     */
    public function createAccount($loginId, $password, $firstName, $lastName, $auth = Constant::USER_ROLES['user'])
    {
        try {
            // TODO: validate (login_id is unique)

            /** save data (login_account table, user_token table) */
            $now = date('Y-m-d H:i:s');
            return LoginAccountTable::getInstance()->insertGetId([
                'login_id'      => $loginId,
                'password'      => md5($password),
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'auth_type'     => $auth,
                'register_date' => $now
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }
}
