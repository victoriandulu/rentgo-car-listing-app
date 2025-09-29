<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
       User::updateOrCreate(
    ['email' => 'victoriamuithyatech@gmail.com'],
    [
        'name' => 'Rentgo Admin',
        'password' => Hash::make('password1234'),
        'is_admin' => true,
        'is_verified' => true, // ✅ ensure admin is always verified
    ]
);


    }
}
