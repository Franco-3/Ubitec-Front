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
            $table->string('direccion',100);
            $table->float('latitud');
            $table->float('longitud');
            $table->char('tipo');
            $table->integer('orden');
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
