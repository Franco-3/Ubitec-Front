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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('idVehiculo');
            $table->integer('idUsuario')->unsigned();
            $table->foreign('idUsuario')
                    ->references('idUsuario')
                    ->on('usuarios')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('patente',7);
            $table->string('nombre',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
