<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * API Login - Get JWT Token
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $loginResult = $this->userService->attemptLogin(
            $request->username,
            $request->password
        );

        if ($loginResult) {
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => [
                        'id' => $loginResult['user']->id,
                        'username' => $loginResult['user']->user,
                        'created_at' => $loginResult['user']->created_at,
                    ],
                    'token' => $loginResult['token'],
                    'token_type' => $loginResult['token_type'],
                    'expires_in' => $loginResult['expires_in']
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Get authenticated user profile
     */
    public function profile()
    {
        $user = $this->userService->getUserFromToken();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User profile retrieved successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'username' => $user->user,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ]
            ]
        ], 200);
    }

    /**
     * Logout - Invalidate JWT Token
     */
    public function logout()
    {
        $result = $this->userService->logout();

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to logout'
        ], 500);
    }

    /**
     * Refresh JWT Token
     */
    public function refresh()
    {
        $result = $this->userService->refreshToken();

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Token refreshed successfully',
                'data' => [
                    'token' => $result['token'],
                    'token_type' => $result['token_type'],
                    'expires_in' => $result['expires_in']
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to refresh token'
        ], 500);
    }
}