<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;
    protected $table = 'rutas';
    protected $primaryKey = 'idRuta';
    protected $fillable = ['estado', 'kmTotal', 'polyline', 'cities_polyline'];

    public $timestapms = true;
}
