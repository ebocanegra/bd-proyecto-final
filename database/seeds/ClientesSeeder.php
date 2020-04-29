<?php

use Illuminate\Database\Seeder;
use App\clientes;
use Faker\Factory as Faker;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos una instancia de Faker
        $faker = Faker::create();

        // Creamos un bucle para cubrir 5 clientes:
        for ($i=1; $i<=5; $i++)
        {
            // Cuando llamamos al método create del Modelo Cliente
            // se está creando una nueva fila en la tabla.
            clientes::create(
                [

                    'codigo'=>$faker->randomNumber($nbDigits = 4, $strict = false),
                   'nombre'=>$faker->name(),
                   'nif'=>$faker->name(),
                   'direccion'=>$faker->streetName(),
                   'correo'=>$faker->email(),
                   'fechaInscripcion'=>$faker->date(),
                   'tarifa'=>$faker->randomElement(['medio_mes', 'mes', 'trimestre', 'semestre']),
                   'contrasena'=>$faker->name()
                ]
            );
        }
    }
}
