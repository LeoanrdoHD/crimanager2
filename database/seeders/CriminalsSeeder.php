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
        $criminal::factory()->create([
            'first_name' => 'criminal1',
            'last_name' => 'el criminal',
            'identity_number' => '1231232',
            'date_of_birth' => '24/01/24',
            'age' => '15',
        ]);
    }
}