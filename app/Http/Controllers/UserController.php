<?php

namespace App\Http\Controllers;


use App\Common\Constant;
use App\Services\UserService;
use App\Services\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userService, $loginService;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->loginService = new LoginService();
    }

    public function registerAccount(Request $request)
    {
        try {
            if (empty($request->login_id) || empty($request->password)) {
                return response()->json(['status' => false, 'message' => 'login_id or password is required!']);
            }

            $userId = $this->userService->createAccount($request->login_id, $request->password, $request->first_name, $request->last_name, Constant::USER_ROLES['user']);
            if (empty($userId)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => 'Fail òi']);
            }

            $this->loginService->handleLogin($request->login_id, $request->password,'web', 'web');
            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'message' => 'OK', 'data' => ['user_id' => $userId]]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $exception->getMessage()]);
        }
    }

    public function getAppInfo(Request $request)
    {
        try {
            $responseData = [
                'status' => Constant::REQUEST_SUCCESS,
                'user_info' => [
                    'auth_type'  => !empty($request->auth_type) ? $request->auth_type : Constant::USER_ROLES['guest'],
                    'user_id'    => !empty($request->user_id) ? $request->user_id : null,
                    'first_name' => !empty($request->first_name) ? $request->first_name : null,
                    'last_name'  => !empty($request->last_name) ? $request->last_name : null
                ]
            ];

            return response()->json($responseData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $exception->getMessage()]);
        }
    }
}