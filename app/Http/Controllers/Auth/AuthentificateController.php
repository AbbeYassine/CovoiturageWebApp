<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;

class AuthentificateController extends Controller
{
    public function __construct(){

        //$this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    public function authentificate(Request $request)
    {
        $credentials = $request->only('login', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        $user=User::whereLogin($request->input('login'))->get();
        return response()->json(compact('token','user'));
    }
}