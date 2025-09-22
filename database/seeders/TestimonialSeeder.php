<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Website Perusahaan PT Nusantara Jaya' => [
                ['client_name' => 'Budi Santoso', 'testimonial_text' => 'Tim Akar Company bekerja profesional dan tepat waktu. Hasil website sangat memuaskan.'],
            ],
            'Aplikasi Penjualan CV Maju Bersama' => [
                ['client_name' => 'Siti Aminah', 'testimonial_text' => 'Aplikasi penjualan mudah digunakan dan membantu meningkatkan produktivitas tim kami.'],
            ],
            'Portal Produk PT Sinar Teknologi' => [
                ['client_name' => 'Andi Wijaya', 'testimonial_text' => 'Desain portal produk modern dan responsif. Klien kami menyukainya.'],
            ],
        ];

        foreach ($map as $projectTitle => $items) {
            $project = Portfolio::where('project_title', $projectTitle)->first();
            if (!$project) { continue; }
            foreach ($items as $t) {
                Testimonial::updateOrCreate(
                    ['client_name' => $t['client_name'], 'project_id' => $project->project_id],
                    ['testimonial_text' => $t['testimonial_text'], 'project_id' => $project->project_id]
                );
            }
        }
    }
}