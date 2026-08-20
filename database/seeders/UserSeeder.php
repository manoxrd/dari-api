<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
      User::factory(1)->create([
        'name' => "dari",
        'email' => 'dari@gmail.com',
        'role' => UserRole::Admin,
        'password' => 'admin'
      ]);  
    }
}
