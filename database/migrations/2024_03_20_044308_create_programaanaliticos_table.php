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
        Schema::create('programaanaliticos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->integer('generalsyd_id');
            $table->char('comp_profesionales', 700)->comment('competencias profesionales');
            $table->char('comp_und_curr', 800)->comment('competencias de la unidad curricular');
            $table->char('val_act', 400)->comment('valores y actitudes');
            $table->char('temario', 400)->comment('temario');
            $table->char('cont_detallado', 4000)->comment('contenido detallado por tema');
            $table->char('estrategias_didacticas',3000)->comment('estrategias didacticas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programaanaliticos');
    }
};
