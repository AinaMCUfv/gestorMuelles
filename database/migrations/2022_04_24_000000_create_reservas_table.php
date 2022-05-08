<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->integer('numpedido');
            $table->string('tipov');
            $table->integer('carga');
            $table->unsignedBigInteger('idusuario'); 
            $table->foreign('idusuario')->references('id')->on('users');
            $table->timestamp('fecha');
            $table->integer('cancelada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas');
    }
};
