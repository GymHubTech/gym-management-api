<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get the authenticated user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = $request->attributes->get('user');

        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }

        return ApiResponse::success([
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'fullname' => $user->full_name,
            'email' => $user->email,
            'role' => $user->role,
            'phone' => $user->phone,
            'firebase_uid' => $user->firebase_uid,
        ], 'User retrieved successfully');
    }
}

