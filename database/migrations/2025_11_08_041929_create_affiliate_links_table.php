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
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->string('affiliate_url'); // Full affiliate link
            $table->decimal('price', 10, 2)->nullable(); // Store-specific price
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_checked_at')->nullable(); // For price/stock updates
            $table->timestamps();
            
            $table->unique(['product_id', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_links');
    }
};
