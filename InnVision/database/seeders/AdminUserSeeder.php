<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'smomnabatool@gmail.com',
            'password' => Hash::make('smomnabatool@gmail.com'),
            'role' => 'admin',
            'is_approved' => true, // Ensure admin is approved by default
            'request_send' => true, // Ensure admin is approved by default
            'created_at' => now(),
            'updated_at' => now(),
            'profile_picture' => '/images/default_profile_picture.jpg',
        ]);
    }
}
