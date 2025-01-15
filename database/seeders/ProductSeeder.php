<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'title' => 'Razer Kraken X Multi-Platform 7.1 Surround Sound E-Sports Headphone Ultra Lightweight Headset',
            'product_link' => 'https://shopee.com.my/product/806850480/26761510555',
            'price' => 126.90,
            'img_link' => 'https://down-my.img.susercontent.com/file/my-11134207-7r98w-m09qee2i8h0bec',
            'brand' => 'Razer',
        ]);
    }
} 