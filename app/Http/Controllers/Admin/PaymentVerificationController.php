<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentVerificationController extends Controller
{
    // Tampilkan daftar pembayaran yang menunggu verifikasi
    public function index()
    {
        $payments = Payment::where('status', 'pending')
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
        
        if ($payment->status !== 'pending') {
             return back()->with('error', 'Pembayaran sudah diproses sebelumnya.');
        }

        $payment->update(['status' => $request->status]);
        
        $message = ($request->status === 'verified') 
                   ? 'Pembayaran berhasil diverifikasi!' 
                   : 'Pembayaran ditolak.';
        if ($request->status === 'verified' && $payment->status === 'pending_payoff') {
            // Jika ini adalah verifikasi pelunasan penuh, set submission status menjadi fully_paid/verified
            $submission = $payment->submission;
            $submission->status = 'fully_paid'; // Atau 'verified', tergantung ENUM Anda. Kita asumsikan 'approved' adalah status aktif.
            $submission->save();
            $message = 'Pelunasan Dipercepat berhasil diverifikasi. Pengajuan Dinyatakan LUNAS!';
        }

        return redirect()->route('admin.payments.verify.index')
                         ->with('success', $message);
    }
}
