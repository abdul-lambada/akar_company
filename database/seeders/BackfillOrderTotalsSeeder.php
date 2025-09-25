<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackfillOrderTotalsSeeder extends Seeder
{
    public function run(): void
    {
        // Backfill orders.total_amount from invoices.total_amount where order_id matches
        if (Schema::hasTable('orders') && Schema::hasTable('invoices')) {
            // Update orders.total_amount where 0 or NULL
            if (Schema::hasColumn('orders', 'total_amount')) {
                DB::statement(<<<SQL
                    UPDATE orders o
                    JOIN invoices i ON i.order_id = o.order_id
                    SET o.total_amount = i.total_amount
                    WHERE (o.total_amount IS NULL OR o.total_amount = 0)
                      AND i.total_amount IS NOT NULL
                SQL);
            }
            // Optionally backfill alternative monetary columns if they exist
            if (Schema::hasColumn('orders', 'amount')) {
                DB::statement(<<<SQL
                    UPDATE orders o
                    JOIN invoices i ON i.order_id = o.order_id
                    SET o.amount = i.total_amount
                    WHERE (o.amount IS NULL OR o.amount = 0)
                      AND i.total_amount IS NOT NULL
                SQL);
            }
            if (Schema::hasColumn('orders', 'total')) {
                DB::statement(<<<SQL
                    UPDATE orders o
                    JOIN invoices i ON i.order_id = o.order_id
                    SET o.total = i.total_amount
                    WHERE (o.total IS NULL OR o.total = 0)
                      AND i.total_amount IS NOT NULL
                SQL);
            }
        }
    }
}
