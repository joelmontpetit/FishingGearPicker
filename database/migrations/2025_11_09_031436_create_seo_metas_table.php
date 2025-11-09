<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->string('page_type'); // 'home', 'build', 'technique', 'species', 'product', 'product_type'
            $table->unsignedBigInteger('entity_id')->nullable(); // ID de l'entité (build_id, technique_id, etc.)
            $table->string('slug')->nullable(); // Pour identifier la page (ex: 'home', 'techniques-index')
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('twitter_card')->default('summary_large_image');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index pour retrouver rapidement les metas
            $table->index(['page_type', 'entity_id']);
            $table->unique(['page_type', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
