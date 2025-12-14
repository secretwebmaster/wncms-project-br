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
        Schema::create('game_log_template_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_log_template_id')->constrained()->cascadeOnDelete();
            $table->string('variant_key');
            $table->integer('priority')->default(0);
            $table->json('conditions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('content');
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->unique(
                ['game_log_template_id', 'variant_key'],
                'gl_variants_tpl_variant_unique'
            );

            $table->unique(
                ['game_log_template_id', 'priority'],
                'gl_variants_tpl_priority_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_log_template_variants');
    }
};
