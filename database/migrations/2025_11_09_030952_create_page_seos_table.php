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
        Schema::create('page_seos', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique(); // 'home', 'techniques-index', 'species-index', etc.
            $table->string('page_name'); // Display name for admin
            $table->string('seo_title');
            $table->text('seo_description');
            $table->string('seo_keywords')->nullable();
            $table->json('og_tags')->nullable(); // OpenGraph tags
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
