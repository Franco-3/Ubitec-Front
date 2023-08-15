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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('idDireccion');
            $table->integer('idRuta')->unsigned();
            $table->foreign('idRuta')
                    ->references('idRuta')
                    ->on('rutas')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->string('direccion',255);
            $table->double('latitud');
            $table->double('longitud');
            $table->char('tipo');
            $table->integer('orden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
