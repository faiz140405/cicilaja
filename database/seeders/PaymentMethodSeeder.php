<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['name' => 'BRI', 'account_number' => '123456789012', 'holder_name' => 'PT CicilAja', 'is_active' => true],
            ['name' => 'Mandiri', 'account_number' => '09876543210', 'holder_name' => 'PT CicilAja', 'is_active' => true],
            ['name' => 'DANA', 'account_number' => '081234567890', 'holder_name' => 'Admin CicilAja', 'is_active' => true],
        ]);
    }
}
