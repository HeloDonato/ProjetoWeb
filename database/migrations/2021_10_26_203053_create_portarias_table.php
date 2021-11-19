<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portarias', function (Blueprint $table) {
            $table->id();
            $table->string('numPortaria');
            $table->string('titulo');
            $table->string('descricao');
            $table->date('dataInicial');
            $table->date('dataFinal')->nullable();
            $table->boolean('tipo');
            $table->string('origem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portarias');
    }
}
