<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ecorecolect.com'],
            [
                'name'       => 'Administrador',
                'password'   => Hash::make('Admin2025#'), // cámbiala luego
                'user_type'  => 'admin',
                'first_name' => 'Admin',
                'last_name'  => 'EcoRecolect',
                'phone'      => '3103235555',
                'address'    => 'Sede Central',
                'locality'   => 'Chapinero',
            ]
        );
    }
}
