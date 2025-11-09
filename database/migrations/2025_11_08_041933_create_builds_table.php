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
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technique_id')->constrained()->onDelete('cascade');
            $table->foreignId('species_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('budget_tier', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->json('meta_tags')->nullable(); // SEO meta tags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builds');
    }
};
