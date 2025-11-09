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
        Schema::create('build_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('build_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('role')->nullable(); // "primary rod", "main line", "lure choice", etc.
            $table->integer('quantity')->default(1);
            $table->integer('sort_order')->default(0);
            $table->text('notes')->nullable(); // Why this product in this build
            $table->timestamps();
            
            $table->unique(['build_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_product');
    }
};
