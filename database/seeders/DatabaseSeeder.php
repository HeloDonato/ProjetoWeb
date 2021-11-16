<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Servidor::create([
            'id' => '1',
            'nome' => 'teste',
            'sobrenome' => 'teste',
            'email' => 'teste@teste.com',
            'matricula' => 'teste',
            'cargo' => 'teste@teste.com',
            'funcao' => 'teste',
            'cpf' => 'teste',
        ]);

        \App\Models\User::create([
            'name' => 'teste',
            'sobrenome' => 'teste',
            'email' => 'teste@teste.com',
            'tipoGrupo' => 'super',
            'id_servidor' => '1',
            'password' => '$2y$10$DpJTP1kEBzdeqO2ReJYGoObQJKEq5z3dG4AsYtUbK1Td4LKVVQN3i'
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
