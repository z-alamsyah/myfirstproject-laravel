<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService
{
    /**
     * Attempt to login user with username and password
     * Returns JWT token on successful authentication
     *
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function attemptLogin($username, $password)
    {
        // Find user by username
        $user = User::where('user', $username)->first();

        // If user not found, return null
        if (!$user) {
            return null;
        }

        // Check password using Laravel's Hash facade (secure password verification)
        if (Hash::check($password, $user->password)) {
            // Generate JWT token for the authenticated user
            $token = JWTAuth::fromUser($user);

            return [
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60 // TTL in seconds
            ];
        }

        return null;
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

    /**
     * Get authenticated user from JWT token
     *
     * @return User|null
     */
    public function getUserFromToken()
    {
        try {
            return JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Invalidate JWT token (logout)
     *
     * @return bool
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Refresh JWT token
     *
     * @return array|null
     */
    public function refreshToken()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return [
                'token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}