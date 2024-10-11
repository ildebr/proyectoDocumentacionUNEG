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

        Schema::table('sdd095ds', function (Blueprint $table) {
            //
            $table->Integer('sdd095_version')->comment('version del plan')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::table('sdd095ds', function (Blueprint $table) {
            //
            // $table->char('sdd210ds_estado',1)->comment('Estado del plan')->default('');
            $table->dropColumn('sdd095_version');
        });
    }
};
