<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'f_name' => 'Admin',
            'l_name' => 'khale',
            'email' => 'admin@admin.com',
            'phone' => '01064564850',
            'status' => true,
            'type' => 'admin',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'f_name' => 'Student',
            'l_name' => 'khale',
            'email' => 'student@student.com',
            'phone' => '01064564852',
            'status' => true,
            'type' => 'student',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'f_name' => 'Teacher',
            'l_name' => 'khale',
            'email' => 'teacher@teacher.com',
            'phone' => '01064564855',
            'status' => true,
            'type' => 'teacher',
            'password' => bcrypt('123456'),
        ]);
    }
}
