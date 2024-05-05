<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd200d extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdd200d_plan_asignatura_id',
        'sdd200d_cod_carr',
        'sdd200d_cod_asign',
        'sdd200d_nom_asign',
        'sdd200d_lapso_vigencia',
        'sdd200d_inferior_asignado',
        'sdd200d_superior_asignado',
        'sdd200d_estado'
    ];

}
