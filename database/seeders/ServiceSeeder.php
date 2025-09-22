<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Jasa Pembuatan Website', 'price' => 7500000],
            ['name' => 'Pengembangan Aplikasi Mobile', 'price' => 15000000],
            ['name' => 'Desain Logo & Identitas Branding', 'price' => 2500000],
            ['name' => 'Optimasi SEO', 'price' => 3000000],
            ['name' => 'Manajemen Sosial Media', 'price' => 2000000],
        ];

        foreach ($services as $svc) {
            Service::updateOrCreate(
                ['slug' => Str::slug($svc['name'])],
                ['service_name' => $svc['name'], 'price' => $svc['price']]
            );
        }
    }
}