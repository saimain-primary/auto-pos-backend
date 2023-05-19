<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\JsonApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use JsonApiResponseTrait;

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::guard('user')->attempt($validatedData)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $user = Auth::guard('user')->user();

        $token = $user->createToken('Token for user id ' . $user->id)->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'Successfully login');
    }

    public function user(Request $request)
    {
        return $this->successResponse([
            'user' => $request->user(),
        ], 'User Info');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return $this->successResponse(null, 'Successfully Logout');
    }
}
