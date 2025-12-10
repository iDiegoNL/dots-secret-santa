<?php

use App\Models\User;
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
            $table->string('decoded_name')
                ->nullable();
        });

        // Populate the decoded_name column for existing users
        User::all()->each(function ($user) {
            $user->update(['decoded_name' => decode_binary($user->name)]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('decoded_name')
                ->nullable(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('decoded_name');
        });
    }
};
