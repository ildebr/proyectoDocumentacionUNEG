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
        Schema::create('sdd200ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('sdd200d_plan_asignatura_id')->comment('id del plan de la asignatura presente en la tabla sdd090ds');
            $table->char('sdd200d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd200d_cod_asign', 8)->comment('codigo de la asignatura');
            $table->char('sdd200d_nom_asign', 40)->comment('nombre de la asignatura');
            $table->char('sdd200d_lapso_vigencia', 6)->comment('lapso de vigencia de codigo de asignatura');
            $table->char('sdd200d_inferior_asignado',8)->nullable()->comment('Persona asignada, no puede reasignar plan');
            $table->char('sdd200d_superior_asignado',8)->bullable()->comment('Persona asignada, puede reasignar plan');
            $table->char('sdd200d_estado',2)->comment('estado del plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdd200ds');
    }
};
