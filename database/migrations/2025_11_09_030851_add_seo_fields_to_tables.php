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
        // Add SEO fields to builds table
        Schema::table('builds', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('meta_tags');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
        });

        // Add SEO fields to techniques table
        Schema::table('techniques', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('meta_tags');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
        });

        // Add SEO fields to species table
        Schema::table('species', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('meta_tags');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
        });

        // Add SEO fields to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('meta_tags');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
        });

        // Add SEO fields to product_types table
        Schema::table('product_types', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('sort_order');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('builds', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('techniques', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('species', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });

        Schema::table('product_types', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description', 'seo_keywords']);
        });
    }
};
