<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Izinkan semua user yang sudah login
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $product = Product::find($this->product_id);
        
        // Pastikan produk ditemukan sebelum validasi harga
        if (!$product) {
            return [
                'product_id' => 'required|exists:products,id',
            ];
        }

        return [
            'product_id' => 'required|exists:products,id',
            'down_payment' => [
                'required',
                'integer',
                'min:0',
                'max:' . $product->credit_price, // DP tidak boleh melebihi harga kredit produk
            ],
            'tenor' => 'required|integer|in:6,12,18,24',
        ];
    }
    
    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'down_payment.max' => 'Uang Muka (DP) tidak boleh melebihi harga kredit produk.',
            'tenor.in' => 'Lama cicilan (tenor) yang dipilih tidak valid.'
        ];
    }
    protected function prepareForValidation()
    {
        // Membersihkan input string (walaupun dalam case ini kebanyakan integer)
        $this->merge([
            'down_payment' => (int) $this->down_payment,
            'tenor' => (int) $this->tenor,
        ]);
    }
}
