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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('greeting')->default('Hello, I am');
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->json('social_links')->nullable();
            $table->json('animated_texts')->nullable();
            $table->string('background_image')->nullable();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
