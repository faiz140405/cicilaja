<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin CicilAja',
            'email' => 'admin@cicilaja.test', // Email default
            'password' => Hash::make('password'), // Password default: 'password'
            'role' => 'admin', // Setting role sebagai 'admin'
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
