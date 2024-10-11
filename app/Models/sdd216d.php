<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd216d extends Model
{
    use HasFactory;

    protected $fillable = [
        "sdd216d_lapso_vigencia" ,
        "sdd216d_cod_carr" ,
        "sdd216d_cod_asign" ,
        "sdd216d_cod_asign_relacion" ,
        "sdd216d_nom_asignatura" ,
        "sdd216d_nom_asignatura_relacion" ,
        "sdd216d_id_tema_asignatura_principal" ,
        "sdd216d_nom_tema_asignatura_principal" ,
        "sdd216d_id_tema_asignatura_relacion" ,
        "sdd216d_nom_tema_asignatura_relacion",
        "sdd216d_version"
    ];
}
