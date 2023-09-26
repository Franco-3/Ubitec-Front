<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;
    protected $table = 'paquetes';
    protected $primaryKey = 'idPaquete';
    protected $fillable = ['idDireccion', 'idVehiculo', 'descripcion', 'pesoUnitario'];

    public $timestamps = true;

    // public function relacion()
    // {
    //     return $this->belongsTo(User::class);
    // }
}