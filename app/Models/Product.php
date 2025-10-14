<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'name',
        'description',
        'cash_price',
        'credit_price',
        'stock',
        'image_path',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    
    public function getImageUrlAttribute()
    {
        // Path di DB adalah 'uploaded_images/products/namafile.jpg'
        if ($this->image_path) {
            // asset() akan menambahkan base URL: http://127.0.0.1:8000/uploaded_images/products/namafile.jpg
            return asset($this->image_path); 
        }

        // Kembalikan placeholder jika path kosong
        return asset('placeholder.jpg'); 
    }
}