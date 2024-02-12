<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json(compact('token'));
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
}
