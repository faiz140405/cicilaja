<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubmissionRequest;

class SubmissionController extends Controller
{
    // Tampilkan form pengajuan
    public function create(Product $product)
    {
        // Pilihan Tenor
        $tenors = [6, 12, 18, 24];
        
        return view('user.submissions.create', compact('product', 'tenors'));
    }

    // Simpan data pengajuan
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'down_payment' => 'required|integer|min:0|max:' . $product->credit_price,
            'tenor' => 'required|integer|in:6,12,18,24',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        // --- LOGIKA PERHITUNGAN CICILAN (BUNGA 10% FLAT) ---
        $bunga = 0.10;
        $sisaHarga = $product->credit_price - $validated['down_payment'];
        
        // Total Hutang = Sisa Harga + (Sisa Harga x Bunga)
        $totalHutang = $sisaHarga + ($sisaHarga * $bunga);
        
        // Cicilan Bulanan = Total Hutang / Tenor
        $cicilanPerBulan = ceil($totalHutang / $validated['tenor']); // Menggunakan ceil agar angka bulat ke atas
        // --- END LOGIKA PERHITUNGAN ---
        
        Auth::user()->submissions()->create([
            'product_id' => $product->id,
            'down_payment' => $validated['down_payment'],
            'tenor' => $validated['tenor'],
            'total_credit_amount' => $totalHutang,
            'monthly_installment' => $cicilanPerBulan,
            'status' => 'pending', // Status default
        ]);

        // --- TAMBAHKAN NOTIFIKASI FLASH UNTUK ADMIN ---
        session()->flash('new_submission', 'Pengajuan baru telah masuk dari ' . Auth::user()->name . '. Mohon segera diperiksa.');
        // ----------------------------------------------

        return redirect()->route('user.dashboard')
                         ->with('success', 'Pengajuan kredit Anda untuk produk ' . $product->name . ' berhasil dikirim. Menunggu review Admin.');
    }
}