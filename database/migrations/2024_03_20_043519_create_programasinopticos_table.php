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
        Schema::create('programasinopticos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->integer('generalsyd_id');
            $table->char('comp_profesionales_basicas', 1000)->comment('competencias profesionales basicas de un ingeniero uneg');
            $table->char('comp_prof_especificas', 1000);
            $table->char('sinopsis_tema',2000)->comment('sinopsis de contenido del tema');
            $table->char('estrategias_didacticas', 1500)->comment('estrategias didacticas');
            $table->char('estrategias_evaluacion', 1000)->comment('estrategias de evaluacion');
            $table->char('bibliografia',1000);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programasinopticos');
    }
};
