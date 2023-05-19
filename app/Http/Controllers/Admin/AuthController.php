<?php

namespace App\Http\Controllers\Admin;

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


        if (!Auth::guard('admin')->attempt($validatedData)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $admin = Auth::guard('admin')->user();

        $token = $admin->createToken('Token for admin id ' . $admin->id)->plainTextToken;

        return $this->successResponse([
            'user' => $admin,
            'token' => $token,
        ], 'Successfully login');
    }

    public function user(Request $request)
    {
        return $this->successResponse([
            'user' => $request->user(),
        ], 'Admin Info');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return $this->successResponse(null, 'Successfully Logout');
    }
}
