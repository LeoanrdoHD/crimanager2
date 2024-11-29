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
      
        User::create([
            'name' => 'Juan Peres',
            'email' => 'sadmin@example.com',
            'password'=> '12345678',
            'ci_police'=> '12345678',
        ])->assignRole('Admin');
    }
}
