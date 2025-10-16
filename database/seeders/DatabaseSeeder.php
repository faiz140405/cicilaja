<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\PaymentMethodSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contoh user testing yang tidak bentrok dengan admin
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testing@cicilaja.test', 
        ]);
        
        $this->call([
            AdminUserSeeder::class, 
            ProductCategorySeeder::class,
            PaymentMethodSeeder::class,
        ]);
        
        // Opsional: Buat 10 user biasa (role 'user' default)
        User::factory(10)->create();
    }
}
