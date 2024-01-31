<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $isValid = true;
        $isLoginPassed = false;
        $errorMsg = '';
        $roleLogin = '';
        $user = null;
        if(!$request->has('role') || empty($request->role)){
            $isValid = false;
            $errorMsg = 'role tidak sesuai';
        }else{
            $roleLogin = $request->role;
        }

    	$usernameField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if($isValid && Auth::attempt([$usernameField => $request->username, 'password' => $request->password])){
            $isLoginPassed = true;
            $user = Auth::user();
            $authRole = $user->role;
            if($roleLogin=='admin'){
                //roleLogin admin
                if($authRole=='admin' || $authRole=='staf'){
                    $isValid = true;
                }else{
                    $isValid = false;
                    $errorMsg = 'tidak memiliki akses untuk halaman ini';
                }
            }else{
                //roleLogin buyer
                if($authRole=='buyer' || $authRole=='member'){
                    $isValid = true;
                }else{
                    $isValid = false;
                    $errorMsg = 'tidak memiliki akses untuk halaman ini';
                }
            }

        }else{
            $isValid = false;

        }

        if($isValid){

            $token =  $user->createToken('pifacia')->plainTextToken;
            $response = [
	            'code' => 200,
	            'message' => 'login success',
	            'data' => $user,
	            'token' => $token,
	        ];
	        return response()->json($response, 200);

        }else{

            if($isLoginPassed){
                $request->user()->tokens()->delete();
            }

            if(empty($errorMsg)){
                $errorMsg = 'kredensial yang diberikan salah';
            }

            $response = [
	            'code' => 401,
	            'message' => $errorMsg,
	            'usernameField' => $usernameField,
	            'username' => $request->username,
	            'password' => $request->password,
	        ];
	        return response()->json($response, 401);

        }

    }

    public function logout(Request $request)
	{
	    $request->user()->tokens()->delete();
	    //auth()->user()->tokens()->delete();
	    $response = [
	            'code' => 200,
	            'message' => 'logged out',
	    ];
	    return response()->json($response, $response['code']);
	}


}
