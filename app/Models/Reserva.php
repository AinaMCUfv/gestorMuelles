<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Reserva extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numpedido',
        'tipov',
        'carga',
        'idusuario',
        'fecha',
        'cancelada',
    ];

}
