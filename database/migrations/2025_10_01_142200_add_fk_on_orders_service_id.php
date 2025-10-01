<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'service_id') && Schema::hasTable('services')) {
            Schema::table('orders', function (Blueprint $table) {
                // Ensure index exists for service_id (some DBs require index before FK)
                $table->index('service_id', 'orders_service_id_index');
            });
            // Try adding FK if supported by the current database
            try {
                Schema::table('orders', function (Blueprint $table) {
                    $table->foreign('service_id', 'orders_service_id_foreign')
                          ->references('service_id')->on('services')
                          ->nullOnDelete();
                });
            } catch (\Throwable $e) {
                // Silently ignore if FK cannot be added (e.g., SQLite, old MySQL)
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'service_id')) {
            // Drop FK if present
            try {
                Schema::table('orders', function (Blueprint $table) {
                    $table->dropForeign('orders_service_id_foreign');
                });
            } catch (\Throwable $e) {
                // ignore if not present
            }
            // Drop explicit index if present
            try {
                Schema::table('orders', function (Blueprint $table) {
                    $table->dropIndex('orders_service_id_index');
                });
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }
};
