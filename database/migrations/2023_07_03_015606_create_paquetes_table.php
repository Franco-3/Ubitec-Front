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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->increments('idPaquete');
            $table->unsignedInteger('idDireccion');
            $table->unsignedInteger('idVehiculo')->nullable();
            $table->string('descripcion', 50);
            $table->float('pesoUnitario')->nullable();
            $table->timestamps();

            $table->foreign('idDireccion')->references('idDireccion')->on('direcciones');
            $table->foreign('idVehiculo')->references('idVehiculo')->on('vehiculos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
