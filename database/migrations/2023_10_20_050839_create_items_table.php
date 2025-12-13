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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('player_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('game_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();
            $table->integer('z')->nullable();
            $table->integer('times')->nullable();
            $table->json('value')->nullable();
            $table->boolean('is_equipped')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
