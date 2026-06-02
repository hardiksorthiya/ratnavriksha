<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'gold_karat')) {
                $table->string('gold_karat')->nullable()->after('ratio');
            }
            if (! Schema::hasColumn('products', 'gold_weight')) {
                $table->string('gold_weight')->nullable()->after('gold_karat');
            }
            if (! Schema::hasColumn('products', 'gold_hallmarked')) {
                $table->boolean('gold_hallmarked')->default(false)->after('gold_weight');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['gold_hallmarked', 'gold_weight', 'gold_karat'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
