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
        //

        Schema::create('sdd095ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd095_lapso_vigencia', 6)->comment('lapso de vigencia');
            $table->char('sdd095_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd095_cod_asign', 8)->comment('codigo de la asignatura');
            $table->text('sdd095_nom_asignatura')->comment('nombre de la asignatura padre');
            $table->char('sdd095_asignatura_relacion_cod',8)->comment('codigo de la asignatura con la que esta relacionada');
            $table->text('sdd095_asignatura_relacion_nombre')->comment('nombre en texto plano de la asignatura relacionada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
