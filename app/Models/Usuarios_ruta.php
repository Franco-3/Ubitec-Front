<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios_ruta extends Model
{
    use HasFactory;
    protected $table = 'Usuarios_ruta';
    protected $primaryKey = 'iduserRuta';
    protected $fillable = ['idRuta', 'idUsuario', 'idVehiculo'];

    public $timestamps = true;

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'idRuta', 'idRuta');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }
}
