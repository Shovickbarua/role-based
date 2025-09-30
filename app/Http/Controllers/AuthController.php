<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use CommonTrait;

    public function login(Request $request)
    {
       $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
 
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError(['message' => 'Authentication Error'], 401);
        }

        $tokenName = 'auth_token_' . $request->email . '_' . now()->timestamp;
        $token = $user->createToken($tokenName)->plainTextToken;

        return $this->sendResponse(['token' => $token, 'message' => 'Logged In successfully']);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse(['message' => 'Logged Out successfully']);
    }
}
