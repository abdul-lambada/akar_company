<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 15 invoice contoh
        Invoice::factory()->count(15)->create();
    }
}
