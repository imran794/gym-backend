<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $userdata = $request->only('email','password');

        $validator = Validator::make($userdata,[
            'email'      => 'required|email|exists:users',
            'password'   => 'required|min:6'
        ]);

        if ($validator->fails()) validate_response($validator->errors());

        if (Auth::attempt($userdata)) {
            
            $user = Auth::user();
            $data['token_type']   = 'Bearer';
            $data['access_token'] = $user->createToken('usertoken')->accessToken;
            $data['user'] = $user;
            return success_response($data,'Login Success');

        }else{
            return error_response('Unauthorized', 401);
        }

    }

    public function register()
    {
        // code...
    }

 
}
