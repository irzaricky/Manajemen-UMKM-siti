<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Admin', 'Yanto',
            'email' => 'admin@example.com', 'lukmantoadyan@gmail.com',
            'password' => Hash::make('arsyada123'),Hash::make('yant0balap'),
        ];

        User::create($user);
    }
}