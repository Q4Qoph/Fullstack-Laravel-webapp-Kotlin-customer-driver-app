<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test User',
            'username' => 'test',
            'phone' => '1234567890',
            'password' => '1234', // Will be automatically hashed
        ]);
    }
}
