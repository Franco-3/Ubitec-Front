<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios_ruta', function (Blueprint $table) {
            $table->increments('idUserRuta');
            $table->integer('idRuta')->unsigned();
            $table->foreign('idRuta')
                    ->references('idRuta')
                    ->on('rutas')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')
                    ->references('idUsuario')
                    ->on('usuarios')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('idVehiculo')->unsigned();
            $table->foreign('idVehiculo')
                    ->references('idVehiculo')
                    ->on('vehiculos')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios_ruta');
    }
};
