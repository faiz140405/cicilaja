<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'down_payment',
        'tenor',
        'monthly_installment',
        'total_credit_amount',
        'status',
    ];
    
    // Konversi status ke enum saat mengambil data
    protected $casts = [
        'status' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    public function getPayoffAmountAttribute(): int
    {
        // Total hutang yang harus dicicil (sudah termasuk bunga di awal)
        $totalCreditAmount = $this->total_credit_amount;
        
        // Total periode yang sudah diverifikasi lunas
        $verifiedPaymentsCount = $this->payments()->where('status', 'verified')->count();
        
        // Total nilai yang sudah dibayar (Cicilan bulanan * periode lunas)
        $amountPaidToDate = $this->monthly_installment * $verifiedPaymentsCount;
        
        // Sisa total yang harus dibayar (estimasi)
        $remainingPayoff = $totalCreditAmount - $amountPaidToDate;

        return max(0, $remainingPayoff);
    }
    
    /**
     * Sisa periode cicilan
     */
    public function getPeriodsLeftAttribute(): int
    {
        return $this->tenor - $this->payments()->where('status', 'verified')->count();
    }
}
