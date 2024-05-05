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
        Schema::create('sdd100ds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('sdd100d_cod_carr', 4)->comment('codigo de la carrera');
            $table->char('sdd100d_cod_plan', 2)->comment('codigo del plan');
            $table->char('sdd100d_lapso', 6)->comment('lapso academico de vigencia del plan');
            $table->char('sdd100d_status', 6)->comment('Estado del pensum');
            $table->integer('sdd100d_total_uc')->nullable();
            $table->integer('sdd100d_total_uc_tecnico')->nullable();
            $table->char('sdd100d_nivel', 1)->nullable();
            $table->integer('sdd100d_total_electivas')->nullable();
            $table->char('sdd100d_aplica_PID', 1)->nullable();
            $table->char('sdd100d_aplica_tecnico', 1)->nullable();
            $table->char('sdd100d_pasantia_y_tg', 1)->nullable()->comment('Determina si el estudiante debe cursar pasantia Y trabajo de grado');
            $table->char('sdd100d_aplica_EJE', 1)->nullable();
            $table->char('sdd100d_aplica_PASANTIA', 1)->nullable();
            $table->char('sdd100d_nuevo', 1)->nullable()->comment('indica si el plan es nuevo ( S )');
            $table->char('sdd100d_total_nivel', 2)->nullable()->comment('numero total de niveles a alcanzar para aprobar la carrera');
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
