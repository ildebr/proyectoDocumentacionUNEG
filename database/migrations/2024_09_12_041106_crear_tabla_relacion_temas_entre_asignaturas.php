<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // tabla para relacionar temas de una asignatura con un tema de otra asignatura
    public function up(): void
    {
        //
        Schema::create('sdd216ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd216d_lapso_vigencia', 6)->comment('lapso de vigencia');
            $table->char('sdd216d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd216d_cod_asign', 8)->comment('codigo de la asignatura principal');
            $table->char('sdd216d_cod_asign_relacion', 8)->comment('codigo de la asignatura a la que esta relacionada');
            $table->text('sdd216d_nom_asignatura')->comment('nombre de la asignatura padre');
            $table->text('sdd216d_nom_asignatura_relacion')->comment('nombre de la asignatura con la que esta relacionada');
            $table->integer('sdd216d_id_tema_asignatura_principal');
            $table->text('sdd216d_nom_tema_asignatura_principal');
            $table->integer('sdd216d_id_tema_asignatura_relacion');
            $table->text('sdd216d_nom_tema_asignatura_relacion');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('sdd216ds');
    }
};
