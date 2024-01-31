<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserServices {

    public static function getUserByToken($request){
        $token = $request->header('Authorization');
        if ($token) {
            // Attempt to authenticate the user based on the token
            $user = auth()->setToken($token)->user();
            if ($user) {
                // User authenticated successfully
                return [
                    'code' => 200,
                    'message' => 'berhasil mengambil data user',
                    'data' => $user
                ];
            } else {
                // Invalid token or user not found
                return [
                    'code' => 401,
                    'message' => 'gagal mengambil data user. Harap autorisasi terlebih dahulu',
                    'data' => '',
                ];
            }
        } else {
            // Token not provided
            return [
                'code' => 401,
                'message' => 'token tidak tersedia',
                'data' => '',
            ];
        }
    }

}
