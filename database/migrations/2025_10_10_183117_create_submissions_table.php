<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang mengajukan
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Produk yang diajukan
            
            $table->unsignedBigInteger('down_payment'); // Uang Muka (DP)
            $table->unsignedInteger('tenor'); // Lama Cicilan (bulan)
            
            $table->unsignedBigInteger('monthly_installment'); // Cicilan Per Bulan (Otomatis hitung)
            $table->unsignedBigInteger('total_credit_amount'); // Total Hutang yang dicicil
            
            // Status pengajuan: pending (default), approved, rejected
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
