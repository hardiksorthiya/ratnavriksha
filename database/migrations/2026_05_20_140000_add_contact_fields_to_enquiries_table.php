<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('enquiries')) {
            return;
        }

        Schema::table('enquiries', function (Blueprint $table) {
            if (! Schema::hasColumn('enquiries', 'email')) {
                $table->string('email')->nullable()->after('name');
            }

            if (! Schema::hasColumn('enquiries', 'subject')) {
                $table->string('subject')->nullable()->after('email');
            }

            if (Schema::hasColumn('enquiries', 'phone')) {
                $table->string('phone')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('enquiries')) {
            return;
        }

        Schema::table('enquiries', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('enquiries', 'email')) {
                $dropColumns[] = 'email';
            }

            if (Schema::hasColumn('enquiries', 'subject')) {
                $dropColumns[] = 'subject';
            }

            if (! empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }

            if (Schema::hasColumn('enquiries', 'phone')) {
                $table->string('phone')->nullable(false)->change();
            }
        });
    }
};
