<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

    	User::create(['name' => 'dad', 'level' => 1, 'email' => 'dad@gmail.com','password' => Hash::make('dad')]);//爸爸
        User::create(['name' => 'older', 'level' => 0, 'email' => 'older@gmail.com' ,'password' => Hash::make('older')]);//哥哥
        User::create(['name' => 'younger', 'level' => 0, 'email' => 'younger@gmail.com' ,'password' => Hash::make('younger')]);//弟弟
    }
}
