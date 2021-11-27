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
        \App\Models\User::create([
            'id' => '1',
            'email' => 'teste@teste.com',
            'tipoGrupo' => 'super',
            'password' => '$2y$10$DpJTP1kEBzdeqO2ReJYGoObQJKEq5z3dG4AsYtUbK1Td4LKVVQN3i',
            'nome' => 'teste',
            'sobrenome' => 'teste',
            'matricula' => 'teste',
            'cargo' => 'teste@teste.com',
            'funcao' => 'teste',
            'cpf' => 'teste',
        ]);
        
        // \App\Models\User::factory(10)->create();
    }
}
