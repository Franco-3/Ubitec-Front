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
            $table->unsignedInteger('idRuta');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedInteger('idVehiculo')->nullable();
            $table->timestamps();

            $table->foreign('idRuta')->references('idRuta')->on('ruta');
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idVehiculo')->references('idVehiculo')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_rutas');
    }
};
