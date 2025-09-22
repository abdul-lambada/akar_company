<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['client_name' => 'PT Nusantara Jaya', 'email' => 'kontak@nusantarajaya.co.id', 'whatsapp' => '6281234567890', 'address' => 'Jl. Merdeka No. 10, Jakarta Pusat'],
            ['client_name' => 'CV Maju Bersama', 'email' => 'info@majubersama.id', 'whatsapp' => '6281122334455', 'address' => 'Jl. Diponegoro No. 22, Bandung'],
            ['client_name' => 'PT Sinar Teknologi', 'email' => 'halo@sinartk.co.id', 'whatsapp' => '6281398765432', 'address' => 'Jl. Sudirman No. 88, Surabaya'],
        ];

        foreach ($clients as $c) {
            Client::updateOrCreate(
                ['client_name' => $c['client_name']],
                $c
            );
        }
    }
}