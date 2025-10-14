<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom ENUM di tabel 'submissions'
        DB::statement("ALTER TABLE submissions CHANGE status status ENUM('pending', 'approved', 'rejected', 'pending_payoff') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Saat rollback, kembalikan ke ENUM sebelumnya
        DB::statement("ALTER TABLE submissions CHANGE status status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};