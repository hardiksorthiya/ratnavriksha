<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('stone_id')->nullable();
            $table->string('featured_type')->nullable();
            $table->string('featured_path')->nullable();
            $table->foreignId('shape_id')->nullable()->constrained('shapes')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('clarity_id')->nullable()->constrained('clarities')->nullOnDelete();
            $table->foreignId('cut_id')->nullable()->constrained('cuts')->nullOnDelete();
            $table->string('row_weight')->nullable();
            $table->string('polish_weight')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('table_percent')->nullable();
            $table->string('total_depth')->nullable();
            $table->string('ratio')->nullable();
            $table->text('remarks')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('product_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('type', ['image', 'video']);
            $table->string('path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_media');
        Schema::dropIfExists('products');
    }
};
