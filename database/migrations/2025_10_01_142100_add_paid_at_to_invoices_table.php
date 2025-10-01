<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invoices') && !Schema::hasColumn('invoices', 'paid_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dateTime('paid_at')->nullable()->after('status');
                $table->index('paid_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('invoices') && Schema::hasColumn('invoices', 'paid_at')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->dropIndex(['paid_at']);
                $table->dropColumn('paid_at');
            });
        }
    }
};
