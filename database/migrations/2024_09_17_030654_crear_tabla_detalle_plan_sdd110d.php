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
        Schema::create('sdd110ds', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->char('sdd110d_lapso_vigencia', 6)->comment('lapso de vigencia');
            $table->char('sdd110d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd110d_cod_asign', 8)->comment('codigo de la asignatura');
            $table->char('sdd110d_cod_plan', 2)->comment('codigo de la asignatura');
            $table->integer('sdd110d_semestre')->comment('semestre de la asignatura');
            $table->char('sdd110d_estatus', 1)->nulablle()->comment('codigo de la asignatura');
            $table->char('sdd110d_ha', 3)->nullable()->default('0')->comment('horas academicas');
            $table->integer('sdd110d_had')->nullable()->empty()->comment('Hora de asustencias semanales docente');
            $table->integer('sdd110d_had_mentor')->nullable(); 
            $table->char('sdd110d_componente', 4)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('sdd210d');
        Schema::dropIfExists('sdd110ds');
    }
};
