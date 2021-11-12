<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServidoresPortariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servidores_portarias', function (Blueprint $table) {
            $table->foreignId('servidores_id')->references('id')->on('servidores')->onDelete('cascade');
            $table->foreignId('portarias_id')->references('id')->on('portarias')->onDelete('cascade');
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
        Schema::dropIfExists('servidores_portarias');
    }
}
