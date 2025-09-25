<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'service_id')) {
                $table->unsignedInteger('service_id')->nullable()->after('customer_whatsapp');
                // Optional FK if services table and key exist
                if (Schema::hasTable('services')) {
                    // Older MySQL versions may not support adding FK without index; keep it simple/optional
                    // $table->foreign('service_id')->references('service_id')->on('services')->nullOnDelete();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'service_id')) {
                // $table->dropForeign(['service_id']); // if FK added
                $table->dropColumn('service_id');
            }
        });
    }
};
