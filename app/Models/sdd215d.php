<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd215d extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdd215d_cod_carr',
        'sdd215d_cod_asign',
        'sdd215d_lapso_vigencia',
        'sdd215d_version',
        
        'sdd215ds_orden_tema',
        'sdd215ds_nombre_tema',
        'sdd215ds_contenido_tema',
        'sdd215ds_profesor_creador'
    ];
}
