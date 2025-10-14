<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

return new class extends Migration
{   
    public function up(): void
    {
        // MySQL tidak mengizinkan penambahan nilai ke ENUM menggunakan Schema::table.
        // Kita harus menggunakan query DB mentah untuk mengubah kolom ENUM.
        DB::statement("ALTER TABLE payments CHANGE status status ENUM('pending', 'verified', 'rejected', 'pending_payoff') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Saat rollback, hapus nilai 'pending_payoff'
        DB::statement("ALTER TABLE payments CHANGE status status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending'");
    }
};
