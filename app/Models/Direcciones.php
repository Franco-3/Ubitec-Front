<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direcciones extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey = 'idDireccion';
    protected $fillable = [
        'idRuta', 'direccion', 'latitud', 'longitud', 'tipo', 'orden', 'estado', 'descripcion', 'imagen'
    ];

    // Si no deseas utilizar los timestamps 'created_at' y 'updated_at', establece el siguiente atributo a false
    public $timestamps = true;

    // Relación con el modelo 'Ruta'
    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'idRuta', 'idRuta');
    }
}
