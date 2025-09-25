<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil semua seeder (data Indonesia)
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            ClientSeeder::class,
            PortfolioSeeder::class,
            TestimonialSeeder::class,
            PostSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            BackfillOrderTotalsSeeder::class,
        ]);
    }
}
