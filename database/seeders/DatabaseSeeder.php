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
            'name' => 'A New Hope',
            'sobrenome' => 'A New Hope',
            'email' => 'teste@teste.com',
            'password' => 'teste123'
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
