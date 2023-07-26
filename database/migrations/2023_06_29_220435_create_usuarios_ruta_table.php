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
        Schema::create('user_ruta', function (Blueprint $table) {
            $table->increments('idUserRuta');
            $table->integer('idRuta')->unsigned();
            $table->foreign('idRuta')
                    ->references('idRuta')
                    ->on('rutas')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->unsignedBigInteger('idUsuario');
            $table->foreign('idUsuario')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('idVehiculo')->unsigned()->nullable();
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
        Schema::dropIfExists('user_ruta');
    }
};
