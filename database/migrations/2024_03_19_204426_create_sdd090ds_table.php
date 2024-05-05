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
        Schema::create('sdd090ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd090d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd090d_cod_asign', 8)->comment('codigo de la asignatura');
            $table->char('sdd090d_nom_asign', 40)->comment('nombre de la asignatura');
            $table->decimal('sdd090d_uc', 2, 0)->comment('unidades de creditos de la asignatura');
            $table->char('sdd090d_tipo_asig', 1)->comment('Tipo de asignatura');
            $table->char('sdd090d_lapso_vigencia', 6)->comment('lapso de vigencia de codigo de asignatura');
            $table->char('sdd090d_nivel_asignatura', 1)->comment('Nivel de la asignatura, unico, rofesional');
            $table->char('sdd090d_nombre_largo', 100);
            $table->char('sdd090d_alias_cod_asign', 8);
            $table->char('sdd090d_tipo_tachira', 1)->comment('tipo asignatura valido para las del unet tachira');
            $table->integer('sdd090d_uc_mentor');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdd090ds');
    }
};
