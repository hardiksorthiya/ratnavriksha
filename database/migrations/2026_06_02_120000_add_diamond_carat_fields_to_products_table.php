<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'diamond_carat_size')) {
                $table->string('diamond_carat_size')->nullable()->after('cut_id');
            }
            if (! Schema::hasColumn('products', 'diamond_carat_weight')) {
                $table->string('diamond_carat_weight')->nullable()->after('diamond_carat_size');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'diamond_carat_weight')) {
                $table->dropColumn('diamond_carat_weight');
            }
            if (Schema::hasColumn('products', 'diamond_carat_size')) {
                $table->dropColumn('diamond_carat_size');
            }
        });
    }
};
