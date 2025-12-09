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
        Schema::create('gift_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('foods')
                ->nullable();
            $table->string('drinks')
                ->nullable();
            $table->string('snacks')
                ->nullable();
            $table->string('candies')
                ->nullable();
            $table->string('restaurants')
                ->nullable();
            $table->string('colors')
                ->nullable();
            $table->string('scents')
                ->nullable();
            $table->string('sports')
                ->nullable();
            $table->string('stores')
                ->nullable();
            $table->string('books')
                ->nullable();
            $table->string('music')
                ->nullable();
            $table->string('hobbies')
                ->nullable();
            $table->json('preferences')
                ->nullable();
            $table->string('tea_or_coffee')
                ->nullable();
            $table->string('beer_wine_or_spirits')
                ->nullable();
            $table->string('sweet_or_salty')
                ->nullable();
            $table->text('id_really_want')
                ->nullable();
            $table->text('please_avoid')
                ->nullable();
            $table->string('allergies')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_hints');
    }
};
