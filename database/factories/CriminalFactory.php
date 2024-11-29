<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Criminal>
 */
class CriminalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         // Generar una fecha de nacimiento aleatoria en el pasado (por ejemplo, entre 1950 y 2000)
         $dateOfBirth = $this->faker->dateTimeBetween('-70 years', '-20 years')->format('Y-m-d');

         // Calcular la edad basada en la fecha de nacimiento
         $age = \Carbon\Carbon::parse($dateOfBirth)->age;
 
         // Generar un número de identidad en el formato especificado
         $identityNumber = $this->faker->unique()->numberBetween(10000000, 99999999) . ' OR';
 
         return [
             'first_name' => $this->faker->firstName(),
             'last_nameP' => $this->faker->lastName(),
             'last_nameM' => $this->faker->lastName(),
             'identity_number' => $identityNumber,
             'date_of_birth' => $dateOfBirth,
             'age' => $age,
         ];
    }
}
