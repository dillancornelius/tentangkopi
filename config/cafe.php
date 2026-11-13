<?php

return [

    'name' => 'Tentang Kopi',

    // Waktu di database tetap UTC; zona ini hanya dipakai untuk tampilan dan laporan harian.
    'timezone' => 'Asia/Jakarta',

    // Nominal dalam rupiah (bilangan bulat).
    'delivery_fee' => 20000,
    'tax_rate' => 0.10,

    'address' => 'Jl. Jemb. Gambang Raya No.2, RT.19/RW.1, Pejagalan, Kec. Penjaringan, Jakarta Utara, DKI Jakarta 14450',
    'phone' => '+62 896 7111 0711',

    'socials' => [
        ['label' => 'Facebook', 'icon' => 'facebook', 'url' => 'https://www.facebook.com/share/1EL8rFzgH6/'],
        ['label' => 'Instagram', 'icon' => 'instagram', 'url' => 'https://www.instagram.com/tentangkopi.official'],
        ['label' => 'YouTube', 'icon' => 'youtube', 'url' => 'https://youtube.com/@sjibrandgroup8505'],
        ['label' => 'TikTok', 'icon' => 'tiktok', 'url' => 'https://www.tiktok.com/@tentangkopispace'],
    ],

    // Kartu kategori di beranda. "subcategory" dicocokkan dengan nama subkategori di database.
    'home_cards' => [
        ['label' => 'Coffee', 'image' => 'assets/home3.jpg', 'subcategory' => 'Cold Coffee'],
        ['label' => 'Tentang Toast', 'image' => 'assets/home4.jpg', 'subcategory' => 'Toast'],
        ['label' => 'Non-Coffee', 'image' => 'assets/home5.jpg', 'subcategory' => 'Cold Non Coffee'],
    ],

    // Dipakai AdminSeeder. Jika password kosong, seeder membuat password acak dan menampilkannya.
    'admin' => [
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD'),
    ],
];
