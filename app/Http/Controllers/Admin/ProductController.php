<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // READ: Tampilkan daftar produk
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // CREATE: Tampilkan form tambah produk
    public function create()
    {
        $categories = ProductCategory::pluck('name', 'id');
        return view('admin.products.create', compact('categories'));
    }

    // STORE: Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'cash_price' => 'required|integer|min:0',
            'credit_price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Definisikan folder di dalam public/
            $destinationPath = public_path('uploaded_images/products'); 

            // Pastikan direktori tujuan ada (jika belum ada, akan dibuat)
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            // Simpan file langsung ke folder public/
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move($destinationPath, $imageName);
            
            // Simpan path relatif ke database
            $validated['image_path'] = 'uploaded_images/products/' . $imageName; 
        }
        
        // Sesuaikan nama field 'image' menjadi 'image_path'
        if(isset($validated['image'])) unset($validated['image']); 
        
        Product::create($validated);
    }

    // EDIT: Tampilkan form edit produk
    public function edit(Product $product)
    {
        $categories = ProductCategory::pluck('name', 'id');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // UPDATE: Update data produk
    public function update(Request $request, Product $product)
    {
        // ... (validasi lainnya)

        if ($request->hasFile('image')) {
            // Hapus gambar lama (dari folder public yang baru)
            if ($product->image_path && File::exists(public_path($product->image_path))) {
                File::delete(public_path($product->image_path));
            }

            $destinationPath = public_path('uploaded_images/products'); 
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->move($destinationPath, $imageName);
            
            $validated['image_path'] = 'uploaded_images/products/' . $imageName;
        } else {
             // Pastikan field 'image' tidak ikut di-update jika kosong
             if(isset($validated['image'])) unset($validated['image']);
        }
        
        $product->update($validated);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    // DESTROY: Hapus produk
    public function destroy(Product $product)
    {
        // Hapus file gambar dari folder public/uploaded_images
        if ($product->image_path && File::exists(public_path($product->image_path))) {
            File::delete(public_path($product->image_path));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}