<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['project_title' => 'Website Perusahaan PT Nusantara Jaya', 'client_name' => 'PT Nusantara Jaya'],
            ['project_title' => 'Aplikasi Penjualan CV Maju Bersama', 'client_name' => 'CV Maju Bersama'],
            ['project_title' => 'Portal Produk PT Sinar Teknologi', 'client_name' => 'PT Sinar Teknologi'],
        ];

        foreach ($projects as $p) {
            Portfolio::updateOrCreate(
                ['project_title' => $p['project_title']],
                $p
            );
        }
    }
}