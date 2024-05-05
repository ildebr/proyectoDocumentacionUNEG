<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sdd080ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd080d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd080d_nom_carr', 70)->comment('nombre de la carrera');
            $table->char('sdd080d_correlativo', 2)->comment('numero correlativo a usar en las actas de evaluacion');
            $table->char('sdd080d_titulo_tecnico', 70)->comment('nombre del titulo de la carrea a nivel tecnico');
            $table->char('sdd080d_titulo_profesional', 70)->comment('nombre del titulo de la carrera a nivel profesional');
            $table->char('sdd080d_prog_cnu', 10)->comment('codigo de progrma (carrera) asignado por el CNU');
            $table->char('sdd080d_nombre_corto', 50)->comment('nombre corto (abreviado) de la carrera');
            $table->integer('sdd080d_total_uc')->comment('total de las unidades de creditos del pensum de la carrera');
            $table->integer('sdd080d_uc_tecn');
            $table->char('sdd080d_nombre', 50)->comment('nombre corto');
            $table->integer('sdd080d_uc_1er_semestre');
            $table->char('sdd080d_code_area', 2);
            $table->char('sdd080d_orden_tecnicos', 1);
            $table->char('sdd080d_orden_profesional', 1);
            $table->integer('sdd080d_nro_electivas');
            $table->char('sdd080d_tipo_carr', 1);
            $table->char('sdd080d_nom_carr_tipo_titulo', 70);
            $table->char('sdd080d_orden_acto_solmen', 2)->comment('orden generico para acta de grado solemne');
            $table->char('sdd080d_titulo_tec_femenino', 70);
            $table->char('sdd080d_prof_femenino', 70);
            $table->char('sdd080d_iniciales', 4);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdd080ds');
    }
};
