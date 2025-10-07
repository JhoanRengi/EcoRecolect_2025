<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'usuario@eco.test'],
            [
                'name' => 'Usuario Demo',
                'password' => Hash::make('User2025#!'),
                'user_type' => 'cliente',
                'email_verified_at' => now(),
            ]
        );
    }
}
