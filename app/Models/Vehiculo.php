<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'vehiculos';
    protected $primaryKey = 'idVehiculo';
    protected $fillable = [
        'idUsuario',
        'patente',
        'nombre',
    ];

    public $timestapms = true;

    public function asignadoA()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
