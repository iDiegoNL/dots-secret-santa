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
        Schema::table('gift_hints', function (Blueprint $table) {
            $table->string('brights_or_neutrals')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gift_hints', function (Blueprint $table) {
            $table->dropColumn('brights_or_neutrals');
        });
    }
};
