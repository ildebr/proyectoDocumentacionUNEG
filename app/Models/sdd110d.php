<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd110d extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdd110d_lapso_vigencia', 
        'sdd110d_cod_carr', 
        'sdd110d_cod_asign', 
        'sdd110d_cod_plan', 
        'sdd110d_semestre', 
        'sdd110d_estatus', 
        'sdd110d_ha', 
        'sdd110d_had', 
        'sdd110d_had_mentor', 
        'sdd110d_component'
    ];
}
