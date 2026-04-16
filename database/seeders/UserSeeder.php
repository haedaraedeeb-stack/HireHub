<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $users = [
        ['name' => 'Ahmad Mansour', 'email' => 'ahmad@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 1],
        ['name' => 'Sara Ali', 'email' => 'sara@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => false, 'city_id' => 2],
        ['name' => 'John Smith', 'email' => 'john@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 3],
        ['name' => 'Laila Hassan', 'email' => 'laila@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 1],
        ['name' => 'Robert Fox', 'email' => 'robert@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => false, 'city_id' => 4],
        ['name' => 'Mona Zaki', 'email' => 'mona@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 2],
        ['name' => 'David Miller', 'email' => 'david@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 5],
        ['name' => 'Elena Rossi', 'email' => 'elena@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => false, 'city_id' => 6],
        ['name' => 'Omar Salem', 'email' => 'omar@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 1],
        ['name' => 'Sophie Chen', 'email' => 'sophie@client.com', 'password' => bcrypt('password'), 'role' => 'client', 'is_verified' => true, 'city_id' => 9],
        ['name' => 'Haedar Adeeb', 'email' => 'haedar@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 1],
        ['name' => 'Samir Kamel', 'email' => 'samir@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 2],
        ['name' => 'Emily Blunt', 'email' => 'emily@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 3],
        ['name' => 'Khalid Issa', 'email' => 'khalid@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => false, 'city_id' => 1],
        ['name' => 'Maria Garcia', 'email' => 'maria@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 5],
        ['name' => 'Youssef Zen', 'email' => 'youssef@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 1],
        ['name' => 'Anna Taylor', 'email' => 'anna@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 4],
        ['name' => 'Fadi Reda', 'email' => 'fadi@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 2],
        ['name' => 'Li Wei', 'email' => 'li@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 9],
        ['name' => 'Zainab Noor', 'email' => 'zainab@free.com', 'password' => bcrypt('password'), 'role' => 'freelancer', 'is_verified' => true, 'city_id' => 1],
    ];

    foreach ($users as $user) {
        User::create($user);
    }
    }
}
