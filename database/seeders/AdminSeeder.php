<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '123456'
        ]);
        User::create([
            'name' => 'developer',
            'email' => 'dev@gmail.com',
            'password' => 'developer'
        ]);
        User::create([
            'name' => 'tester',
            'email' => 'tester@gmail.com',
            'password' => 'tester'
        ]);
    }
}
