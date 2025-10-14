<?php
namespace App\Http\Controllers\Admin; // Perhatikan namespace jika defaultnya App\Http\Controllers
namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 6 produk yang memiliki stok > 0
        $products = Product::with('category')->where('stock', '>', 0)->latest()->limit(6)->get();
        return view('landing', compact('products'));
    }
    public function faq()
    {
        return view('statics.faq');
    }
    public function terms()
    {
        return view('statics.terms');
    }
    public function allProducts()
    {
        // Ambil semua produk yang stoknya > 0, dengan pagination
        $products = Product::with('category')
                            ->where('stock', '>', 0)
                            ->latest()
                            ->paginate(12); // Tampilkan 12 produk per halaman
        
        return view('statics.all_products', compact('products'));
    }
}