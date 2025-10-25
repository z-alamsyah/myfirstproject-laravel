<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Hash all existing plain text passwords.
     *
     * @return void
     */
    public function up()
    {
        // Get all users with plain text passwords
        $users = User::all();

        foreach ($users as $user) {
            // Check if password is already hashed (if it starts with $2y$, it's already hashed)
            if (!str_starts_with($user->password, '$2y$')) {
                // Hash the plain text password
                $user->password = $user->password; // This will trigger the setPasswordAttribute mutator
                $user->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     * Note: We can't reverse this operation securely as we can't decrypt hashed passwords.
     *
     * @return void
     */
    public function down()
    {
        // For learning purposes, we'll reset to original plain text passwords
        // In production, you should NEVER implement a down migration for password hashing

        User::where('user', 'admin')->update(['password' => '12345']);
        User::where('user', 'john')->update(['password' => 'password']);
        User::where('user', 'jane')->update(['password' => 'secret']);
    }
};