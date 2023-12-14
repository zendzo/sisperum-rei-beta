<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
          'name' => 'Administrator',
          'email' => 'admin@sisperum.com',
          'password' => Hash::make('password'),
          'email_verified_at' => now()
        ]);
    }
}
