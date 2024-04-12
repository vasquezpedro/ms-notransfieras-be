<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsuarioSeeder extends Seeder
{
    public function run()
	{
		for ($i = 0; $i < 10; $i++) {
		    $this->db->table('usuario_rutificado')->insert($this->generateUser());
        }
	}

	private function generateUser(): array
    {
        $faker = Factory::create();

        return [
            
            'nombre' => $faker->name()."dummy",
            'rut' => $faker->random_int(1000000, 30000000),
            'sexo' => 'var',
            'direccion'=> $faker->address(),
            'comuna'=> $faker->country(),
            'fake'=> $faker->boolean(),
            'fecha_registro'=> $faker->date()
        ];
    }
}
