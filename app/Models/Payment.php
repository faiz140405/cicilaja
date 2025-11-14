<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'period',
        'amount_paid',
        'proof_path',
        'status',
        'payment_date',
    ];

    public function getProofUrlAttribute(): string
    {
        if ($this->proof_path) {
            return asset($this->proof_path);
        }
        
        return asset('images/placeholder-proof.png');
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }
}