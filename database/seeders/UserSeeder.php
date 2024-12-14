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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('arsyada123')
            ],
            [
                'name' => 'Yanto',
                'email' => 'lukmantoadyan@gmail.com', 
                'password' => Hash::make('yant0balap')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}