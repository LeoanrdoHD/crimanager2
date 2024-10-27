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
        $User=new User();
        $User::factory()->create([
            'name' => 'Juan Peres',
            'email' => 'sadmin@example.com',
            'password'=> '12345678',
        ]);
    }
}
