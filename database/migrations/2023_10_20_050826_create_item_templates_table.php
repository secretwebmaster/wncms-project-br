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
        Schema::create('item_templates', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('slug');
            $table->string('type');
            $table->string('name');
            $table->string('description')->nullable();
            $table->json('value')->nullable();
            $table->boolean('is_stackable')->default(false);
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_templates');
    }
};
