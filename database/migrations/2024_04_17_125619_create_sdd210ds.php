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
        Schema::create('sdd210ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd210d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd210d_cod_asign', 8)->comment('codigo de la asignatura');
            $table->char('sdd210d_lapso_vigencia', 40)->comment('nombre de la asignatura');
            $table->text('sdd210ds_as_proposito')->comment('Proposito de la asignatura. Compartido por plan analitico y sinoptico.')->nullable();
            $table->text('sdd210ds_as_competencias_genericas')->nullable();
            $table->text('sdd210ds_a_competencias_profesionales')->nullable();
            $table->text('sdd210ds_s_competencias_profesionales_basicas')->nullable();
            $table->text('sdd210ds_s_competencias_profesionales_especificas')->nullable();
            $table->text('sdd210ds_a_competencias_unidad_curricular')->nullable();
            $table->text('sdd210ds_a_valores_actitudes')->nullable();
            $table->text('sdd210ds_as_estrategias_didacticas')->nullable();
            $table->text('sdd210ds_as_estrategias_docentes')->nullable();
            $table->text('sdd210ds_as_estrategias_aprendizajes')->nullable();
            $table->text('sdd210ds_as_bibliografia')->nullable();
            $table->unsignedTinyInteger('sdd210ds_version')->comment('Version del plan')->default('1');
            $table->text('sdd210ds_r_capacidades_profesionales')->nullable();
            $table->text('sdd210ds_r_capacidades')->nullable();
            $table->text('sdd210ds_r_habilidades')->nullable();
            $table->text('sdd210ds_r_red_tematica')->nullable();
            $table->text('sdd210ds_r_red_tematica_foto')->nullable();
            $table->text('sdd210ds_r_descripcion_red_tematica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdd210ds');
    }
};
