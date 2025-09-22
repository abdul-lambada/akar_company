<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@akar.test')->first();
        if (!$author) {
            $author = User::first();
        }
        if (!$author) { return; }

        $posts = [
            [
                'title' => 'Mengenal Layanan Akar Company',
                'content' => 'Akar Company menyediakan layanan pembuatan website, pengembangan aplikasi, dan solusi digital lainnya untuk meningkatkan bisnis Anda.',
                'categories' => ['Teknologi','Bisnis']
            ],
            [
                'title' => 'Tips Memilih Jasa Pembuatan Website',
                'content' => 'Pertimbangkan kebutuhan bisnis, skalabilitas, keamanan, dan kemudahan pengelolaan ketika memilih penyedia jasa pembuatan website.',
                'categories' => ['Pengembangan Web','Produk']
            ],
            [
                'title' => 'Pentingnya Identitas Branding untuk UMKM',
                'content' => 'Identitas branding yang kuat membantu UMKM membangun kepercayaan dan meningkatkan loyalitas pelanggan.',
                'categories' => ['Desain Grafis','Pemasaran Digital']
            ],
            [
                'title' => 'Strategi Pemasaran Digital untuk UKM di Indonesia',
                'content' => 'Mulai dari riset audiens, konten yang relevan, hingga iklan berbayar yang terukur. Fokus pada kanal yang memberi konversi terbaik.',
                'categories' => ['Pemasaran Digital','Bisnis']
            ],
            [
                'title' => 'Cara Mengoptimalkan SEO On-Page',
                'content' => 'Gunakan struktur heading yang rapi, meta yang informatif, alt text pada gambar, serta internal linking yang konsisten.',
                'categories' => ['Pemasaran Digital','Pengembangan Web']
            ],
            [
                'title' => 'Panduan Memilih Tema Desain untuk Brand',
                'content' => 'Pilih palet warna, tipografi, dan gaya visual yang konsisten agar brand mudah dikenali di berbagai kanal.',
                'categories' => ['Desain Grafis','Produk']
            ],
            [
                'title' => 'Membangun Aplikasi Laravel yang Skalabel',
                'content' => 'Pisahkan layer bisnis dengan rapi, gunakan caching, optimalkan query, dan siapkan pipeline CI/CD.',
                'categories' => ['Pengembangan Web','Teknologi']
            ],
            [
                'title' => 'Mengelola Keuangan Proyek IT',
                'content' => 'Tetapkan anggaran, catat jam kerja, dan evaluasi biaya infrastruktur cloud secara berkala.',
                'categories' => ['Keuangan','Bisnis']
            ],
            [
                'title' => 'Manfaat Pelatihan Digital bagi Karyawan',
                'content' => 'Pelatihan digital meningkatkan kompetensi, efisiensi kerja, dan adaptasi terhadap tools modern.',
                'categories' => ['Edukasi','Bisnis']
            ],
            [
                'title' => 'Checklist Keamanan Website Perusahaan',
                'content' => 'Implementasi HTTPS, pembaruan rutin dependency, proteksi XSS/CSRF, backup, dan pemantauan log.',
                'categories' => ['Teknologi','Pengembangan Web']
            ],
        ];

        foreach ($posts as $p) {
            $post = Post::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'user_id' => $author->user_id,
                ]
            );

            $catIds = Category::whereIn('slug', collect($p['categories'])->map(fn($c) => Str::slug($c)))->pluck('category_id')->all();
            if (!empty($catIds)) {
                $post->categories()->syncWithoutDetaching($catIds);
            }
        }
    }
}