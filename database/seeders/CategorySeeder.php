<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Teknologi',
            'Pengembangan Web',
            'Desain Grafis',
            'Pemasaran Digital',
            'Bisnis',
            'Keuangan',
            'Edukasi',
            'Produk',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['category_name' => $name]
            );
        }
    }
}