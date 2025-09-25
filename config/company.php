<?php

return [
    // Identitas perusahaan (bisa diubah lewat .env)
    'name' => env('COMPANY_NAME', 'Akar Company'),
    'address' => env('COMPANY_ADDRESS', 'Jl. Cibiru No.01, Sangkanhurip, Kec. Sindang, Kabupaten Majalengka, Jawa Barat 45471'),
    'email' => env('COMPANY_EMAIL', 'akar@gmail.com'),
    'phone' => env('COMPANY_PHONE', '+62 85156553226'),
    // Path logo relatif terhadap public/ (misal: images/logo.png) atau file di public root (favicon.ico)
    'logo_path' => env('COMPANY_LOGO', 'favicon.ico'),
];
