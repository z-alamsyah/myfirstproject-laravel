<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Create test users with properly hashed passwords.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing users to avoid conflicts
        User::query()->delete();

        // Create test users with properly hashed passwords
        User::create([
            'user' => 'admin',
            'password' => '12345', // Will be automatically hashed by the setPasswordAttribute mutator
        ]);

        User::create([
            'user' => 'john',
            'password' => 'password', // Will be automatically hashed by the setPasswordAttribute mutator
        ]);

        User::create([
            'user' => 'jane',
            'password' => 'secret', // Will be automatically hashed by the setPasswordAttribute mutator
        ]);

        $this->command->info('✅ Test users created with hashed passwords:');
        $this->command->info('   • admin/12345');
        $this->command->info('   • john/password');
        $this->command->info('   • jane/secret');
    }
}