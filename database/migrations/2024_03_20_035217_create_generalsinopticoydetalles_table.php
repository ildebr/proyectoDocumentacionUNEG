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
        Schema::create('generalsinopticoydetalles', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->char('sdd090d_cod_carr', 4);
            $table->char('comp_formacion', 2)->comment('componente de formacion');
            $table->char('prelaciones',100)->comment('prelaciones de la asignatura');
            $table->char('caracter',2)->comment('caracter de la asignatura');
            $table->char('horas_semanales', 2);
            $table->timestamp('fecha_elaboracion');
            $table->char('proposito', 800);
            $table->char('competencias_genericas',800);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generalsinopticoydetalles');
    }
};
