<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vehiculo;
use App\Models\User;
use Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        //Vehiculo : array = ['Deporte', 'Politica', 'Entretenimiento', 'Salud', 'Internacional'];
        
        return [
            "nombre" => fake()->unique()->word(),
            "patente" => fake()->shuffle('abcd136'),
            "idUsuario" => User::all()->random()->id,
        ];
    }
}
