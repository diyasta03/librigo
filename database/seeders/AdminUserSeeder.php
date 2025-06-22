<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@perpus.com')->exists()) {
         User::create([
'name' => 'Admin',
'email' => 'admin@perpustakaan.com',
'password' => bcrypt('password123'),
'role' => 'admin',
            ]);
        }
    }
}
