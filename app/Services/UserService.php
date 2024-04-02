<?php

namespace App\Services;

class UserService
{

    public function login($dataLogin)
    {
        $token = null;
        try {
            if(!$token = auth('api')->attempt($dataLogin)) {
                return ['error' => 1, 'message' => 'email or password invalid!', 'token' => null];
            }
        }catch (\Exception $e) {
            return ['error' => 2, 'message' => $e->getMessage()];
        }
        return ['error' => 0, 'token' => $token];
    }
}

?>
