<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // <-- Tambahkan ini

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik', 
                'description' => 'Gadget, TV, Komputer, dan Peralatan Rumah Tangga.',
            ],
            [
                'name' => 'Kendaraan', 
                'description' => 'Sepeda motor dan mobil bekas.',
            ],
            [
                'name' => 'Perabotan', 
                'description' => 'Furnitur rumah tangga dan kantor.',
            ],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}