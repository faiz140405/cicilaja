<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            ['name' => 'Elektronik', 'description' => 'Gadget, TV, Komputer, dan Peralatan Rumah Tangga.'],
            ['name' => 'Kendaraan', 'description' => 'Sepeda motor dan mobil bekas.'],
            ['name' => 'Perabotan', 'description' => 'Furnitur rumah tangga dan kantor.'],
        ]);
    }
}
