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
    public function allProducts(Request $request)
    {
        $query = Product::with('category')->where('stock', '>', 0);
        $sort = $request->get('sort');
        $search = $request->get('search'); // Tambahkan pencarian jika sudah diimplementasikan

        // Logika Sortir
        if ($sort === 'lowest') {
            $query->orderBy('credit_price', 'asc');
        } elseif ($sort === 'highest') {
            $query->orderBy('credit_price', 'desc');
        } else {
            $query->latest();
        }
        
        // Logika Pencarian (jika ada)
        if ($search) {
             // ... (implementasi logic pencarian) ...
        }

        $products = $query->paginate(12)->withQueryString(); 

        return view('statics.all_products', compact('products', 'sort'));
    }
}