<?php

namespace Database\Seeders;
use App\Models\criminal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class CriminalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criminal = new criminal();
        criminal::factory(50)->create();
        $criminal::factory()->create([
            'first_name' => 'RAMIRO JESUS',
            'last_name' => 'MAMANI FLORES',
            'identity_number' => '7865932',
            'date_of_birth' => '24/01/23',
            'age' => '24',
        ]);
    }
}