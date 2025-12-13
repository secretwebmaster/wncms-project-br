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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('player'); //player | npc
            $table->string('status')->default('alive');
            $table->string('name')->nullable();

            $table->integer('level')->default(1);
            $table->integer('exp')->default(0);
            $table->integer('exp_next')->nullable();

            $table->integer('hp')->nullable(); //hp
            $table->integer('max_hp')->nullable(); //hp
            $table->integer('mp')->nullable(); //mp
            $table->integer('max_mp')->nullable(); //mp
            $table->integer('vit')->nullable(); //hp mp
            $table->integer('str')->nullable(); //atk -> damage
            $table->integer('int')->nullable(); //matk
            $table->integer('dex')->nullable(); //def mdef
            $table->integer('luc')->nullable(); //crit combo events

            $table->integer('location_x')->nullable();
            $table->integer('location_y')->nullable();
            $table->integer('location_z')->nullable();
            $table->integer('previous_location_x')->nullable();
            $table->integer('previous_location_y')->nullable();
            $table->integer('previous_location_z')->nullable();
            $table->integer('kill')->default(0);
            $table->datetime('died_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
