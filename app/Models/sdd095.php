<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd095d extends Model
{
    use HasFactory;

    protected $fillable = [

        'sdd095_cod_carr',
        'sdd095_cod_asign',
        'sdd095_nom_asignatura',
        'sdd095_asignatura_relacion_cod',
        'sdd095_asignatura_relacion_nombre'
    ];
}
