<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    // Tampilkan daftar pembayaran yang menunggu verifikasi
    public function index(Request $request)
    {
        $query = Payment::whereIn('status', ['pending', 'pending_payoff'])
                           ->with('submission.user', 'submission.product');
                           
        $search = $request->get('search');

        if ($search) {
            // Logic pencarian: Cari di nama produk atau di detail user (name/email/phone)
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('submission.user', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('phone_number', 'like', "%{$search}%");
                })
                ->orWhereHas('submission.product', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                });
            });
        }
        $payments = Payment::where('status', 'pending', 'pending_payoff')
                           ->with('submission.user', 'submission.product')
                           ->latest()
                           ->paginate(10);
        
        return view('admin.payments.verification', compact('payments'));
    }

    // Perbarui status pembayaran (verifikasi/tolak)
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);
        
        // Simpan status lama sebelum update
        $oldStatus = $payment->status; 
        
        if ($oldStatus === 'verified' || $oldStatus === 'rejected') {
             return back()->with('error', 'Pembayaran sudah diproses sebelumnya.');
        }

        // UPDATE payment status (Ini harus dilakukan sebelum logic check)
        $payment->update(['status' => $request->status]); 
        $submission = $payment->submission;

        $message = ($request->status === 'verified') 
                    ? 'Pembayaran berhasil diverifikasi!' 
                    : 'Pembayaran ditolak.';
        
        // --- LOGIKA UTAMA PELUNASAN DIPERCEPAT ---
        // Jika aksi adalah 'verified' DAN status lama adalah 'pending_payoff'
        if ($request->status === 'verified' && $oldStatus === 'pending_payoff') {
            
            // Tandai semua periode tersisa (periode di atas periode pembayaran yang baru diverifikasi) menjadi verified
            $lastVerifiedPeriod = $payment->period;
            
            // 1. Loop dan buat semua periode yang tersisa menjadi LUNAS
            for ($i = $lastVerifiedPeriod + 1; $i <= $submission->tenor; $i++) {
                
                // Gunakan updateOrCreate untuk memastikan tidak ada duplikasi
                \App\Models\Payment::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'period' => $i,
                    ],
                    [
                        'amount_paid' => $submission->monthly_installment, 
                        'proof_path' => 'SYSTEM_PAYOFF', 
                        'payment_date' => \Carbon\Carbon::now(),
                        'status' => 'verified', 
                        'created_at' => \Carbon\Carbon::now(),
                    ]
                );
            }
            
            // 2. Update status Submission menjadi LUNAS FINAL
            $submission->status = 'fully_paid';
            $submission->save();
            
            $message = 'Pelunasan Dipercepat berhasil diverifikasi. Pengajuan Dinyatakan LUNAS!';
        }

        return redirect()->route('admin.payments.verify.index')->with('success', $message);
    }
}
