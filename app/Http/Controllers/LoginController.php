<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;
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

            // Retrieve the expiration time of the token
            $expiration = Carbon::now()->addMinutes(config('jwt.ttl'))->format('Y-m-d H:i:s');

             // Return the token and its expiration time in the response
             return response()->json([
                'token' => $token,
                'expires_at' => $expiration
            ]);
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
}
