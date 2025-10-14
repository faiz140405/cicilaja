<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained()->onDelete('cascade'); // Foreign Key ke Kategori
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('cash_price');    // Harga tunai
            $table->unsignedBigInteger('credit_price');  // Harga kredit (bunga/markup)
            $table->unsignedInteger('stock')->default(0);
            $table->string('image_path')->nullable();     // Path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};