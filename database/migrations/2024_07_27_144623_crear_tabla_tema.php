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
        Schema::create('sdd215ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd215d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd215d_cod_asign', 8)->comment('codigo de la asignatura');
            $table->char('sdd215d_lapso_vigencia', 40)->comment('nombre de la asignatura');
            $table->Integer('sdd215d_version', 40)->comment('version del plan');
            
            $table->unsignedTinyInteger('sdd215ds_orden_tema')->comment('Orden de la asignatura relativo a otros temas')->nullable();
            $table->text('sdd215ds_nombre_tema')->comment('Nombre del tema')->nullable();
            $table->text('sdd215ds_contenido_tema')->comment('Contenido del tema')->nullable();
            $table->Integer('sdd215ds_profesor_creador')->comment('Profesor que creo el contenido del tema')->nullable();
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
