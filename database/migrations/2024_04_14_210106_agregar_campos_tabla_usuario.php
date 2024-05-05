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
        Schema::table('users', function (Blueprint $table) {
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('cedula')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Schema::create('users', function (Blueprint $table) {});
    }
};
