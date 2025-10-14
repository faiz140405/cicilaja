<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade'); // Cicilan milik pengajuan mana
            $table->unsignedInteger('period'); // Periode cicilan ke- (1, 2, 3, dst.)
            $table->unsignedBigInteger('amount_paid'); // Jumlah yang dibayar
            $table->string('proof_path')->nullable(); // Path bukti pembayaran (gambar/pdf)
            
            // Status: pending (default), verified, rejected
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamp('payment_date')->nullable(); // Tanggal pembayaran
            $table->timestamps();

            // Mencegah pembayaran periode yang sama dua kali pada satu submission
            $table->unique(['submission_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};