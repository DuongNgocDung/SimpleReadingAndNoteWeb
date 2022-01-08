<?php

namespace App\Http\Controllers;


use App\Common\Constant;
use Illuminate\Http\Request;
use App\Services\LoginService;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    private $loginService;
    public function __construct()
    {
        $this->loginService = new LoginService();
    }

    public function login(Request $request)
    {
        try {
            if (empty($request->login_id) || empty($request->password)) {
                return response()->json(['status' => false, 'message' => 'login_id or password is required!']);
            }
            $userId = $this->loginService->handleLogin($request->login_id, $request->password, 'web', 'web');

            if (empty($userId)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => 'Can not find user.']);
            }

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'message' => 'login success !', 'data' => ['user_id' => $userId]]);
        } catch (\Exception $exception) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $exception->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!isset($request->user_id) || empty($request->user_id)) {
                return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => '[user_id] is required']);
            }
            $this->loginService->handleLogout($request->user_id);

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'message' => 'login success !', 'data' => ['user_id' => $userId]]);
        } catch (\Exception $exception) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $exception->getMessage()]);
        }
    }


    public function loadLoginInfo(Request $request)
    {
        try {
            // TODO: check xem đã login hay chưa, login rồi thì hem load khung login nữa, ở vue cho redirect qua màn hình home

            return response()->json(['status' => Constant::REQUEST_SUCCESS, 'message' => 'Chưa làm gì hết']);
        } catch (\Exception $exception) {
            return response()->json(['status' => Constant::REQUEST_FAIL, 'message' => $exception->getMessage()]);
        }
    }
}