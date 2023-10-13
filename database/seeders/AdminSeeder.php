<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin Name',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'role' => 2,
            'status' => 1,
            'password' => Hash::make('admin'),
        ]);
    }
}