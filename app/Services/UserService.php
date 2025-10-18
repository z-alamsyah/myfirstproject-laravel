<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Attempt to login user dengan username dan password
     * 
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function attemptLogin($username, $password)
    {
        // Cari user berdasarkan username
        $user = User::where('user', $username)->first();
        
        // Jika user tidak ditemukan, return null
        if (!$user) {
            return null;
        }
        
        // Cek password (plain text untuk bahan ajar)
        if ($user->password === $password) {
            return $user;
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
}