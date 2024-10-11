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
        Schema::create('sdd900ds', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->nullable();
            $table->char('sdd900ds_coordinador_de_carrera', 40)->comment('lapso de vigencia');
            $table->char('sdd900ds_coordinador_de_curriculo', 40)->comment('lapso de vigencia');
            $table->integer('sdd900ds_editado_por')->comment('lapso de vigencia');
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
