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
        Schema::table('sdd200ds', function (Blueprint $table) {
            
            $table->unsignedTinyInteger('sdd200d_version')->comment('Version del plan')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sdd200ds', function (Blueprint $table) {
            //
            $table->unsignedTinyInteger('sdd200d_version')->comment('Version del plan')->default('1');
        });
    }
};
