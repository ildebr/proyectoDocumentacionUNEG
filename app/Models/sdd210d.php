<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sdd210d extends Model
{
    use HasFactory;

    protected $fillable = [
        'sdd210d_cod_carr',
        'sdd210d_cod_asign',
        'sdd210d_lapso_vigencia',
        'sdd210ds_as_proposito',
        'sdd210ds_as_competencias_genericas',
        'sdd210ds_a_competencias_profesionales',
        'sdd210ds_s_competencias_profesionales_basicas',
        'sdd210ds_s_competencias_profesionales_especificas',
        'sdd210ds_a_competencias_unidad_curricular',
        'sdd210ds_a_valores_actitudes',
        'sdd210ds_as_estrategias_didacticas',
        'sdd210ds_as_estrategias_docentes',
        'sdd210ds_as_estrategias_aprendizajes',
        'sdd210ds_as_bibliografia',
        'sdd210ds_version',
        'sdd210ds_r_capacidades_profesionales',
        'sdd210ds_r_capacidades',
        'sdd210ds_r_habilidades',
        'sdd210ds_r_red_tematica',
        'sdd210ds_r_red_tematica_foto',
        'sdd210ds_r_descripcion_red_tematica',
        'sdd210ds_estado'
    ];
}
