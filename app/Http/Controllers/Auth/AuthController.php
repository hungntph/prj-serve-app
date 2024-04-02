<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Helper\Response;

class AuthController extends Controller
{
    public $userService;

    public function __construct
    (
        UserService $userService

    )
    {
        $this->userService = $userService;
    }

    public function login(Request $request)
    {
        try {
            $login = $this->userService->login($request->only('email', 'password'));
            if ($login['error']) {
                return Response::dataError(config('constant.code.reverse_code_status.AUTHENTICATE'), [], __($login['message']));
            };
            $userInfo = [
                'name' => auth('api')->user()->name,
                'email' => auth('api')->user()->email,
            ];
            return Response::data(['token' => $login['token'], 'user' => $userInfo]);
        }catch (\Exception $th) {
            return Response::dataError($th->getCode(), ['error'=>[$th->getMessage()]], $th->getMessage());
        }
    }
}
