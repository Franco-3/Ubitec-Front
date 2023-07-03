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
            $table->integer('idDireccion')->unsigned();
            $table->foreign('idDireccion')
                    ->references('idDireccion')
                    ->on('direcciones')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('idVehiculo')->unsigned();
            $table->foreign('idVehiculo')
                    ->references('idVehiculo')
                    ->on('vehiculos')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('descripcion',50);
            $table->float('pesoUnitario')->nullable();
            $table->timestamps();
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
