<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    // READ: Tampilkan daftar semua pengajuan
    public function index()
    {
        $submissions = Submission::with(['user', 'product'])
                                 ->latest()
                                 ->paginate(10);
        
        return view('admin.submissions.index', compact('submissions'));
    }

    // UPDATE STATUS: Menyetujui atau Menolak pengajuan
    public function update(Request $request, Submission $submission)
    {
        // PENTING: Validasi sekarang mencari input 'status'
        $request->validate([
            'status' => 'required|in:approved,rejected', // Validasi status yang datang dari form
        ]);

        $statusToSet = $request->status;

        // Cek apakah status saat ini sudah selesai
        if (in_array($submission->status, ['approved', 'rejected', 'fully_paid'])) {
             return redirect()->route('admin.submissions.index')
                             ->with('error', 'Pengajuan sudah diproses.');
        }

        // --- LOGIKA UTAMA (Sama seperti updateStatus sebelumnya) ---

        // 1. Jika ini adalah verifikasi pelunasan penuh
        if ($statusToSet === 'verified' && $submission->status === 'pending_payoff') {
            
            // a) Tandai semua pembayaran yang belum diverifikasi/lunas menjadi verified
            $unpaidPeriods = $submission->payments()
                                        ->whereNotIn('status', ['verified'])
                                        ->where('period', '>=', $submission->payments()->where('status', 'verified')->count() + 1)
                                        ->get();
            
            // Update semua pembayaran yang belum selesai menjadi verified
            foreach ($unpaidPeriods as $payment) {
                $payment->status = 'verified';
                $payment->save();
            }
            
            // b) Set status submission menjadi LUNAS FINAL
            // Catatan: Asumsi ENUM submissions diperbarui menjadi 'paid' atau 'completed'
            // Jika tidak, kita gunakan 'approved' atau 'rejected' saja.
            $submission->status = 'approved'; 
            $submission->save();
            $message = 'Pelunasan Dipercepat berhasil diverifikasi. Hutang Dinyatakan LUNAS!';
            
        } elseif ($statusToSet === 'approved' || $statusToSet === 'rejected') {
            
            // 2. Verifikasi pengajuan awal ('pending')
            $submission->status = $statusToSet;
            $submission->save();
            $message = ($statusToSet === 'approved') ? 'Pengajuan berhasil disetujui!' : 'Pengajuan ditolak.';
        } else {
             $message = 'Aksi tidak valid.';
        }
        
        return redirect()->route('admin.submissions.index')
                         ->with('success', $message);
    }
    
    // Metode update dan destroy lainnya tidak kita gunakan, hanya index dan updateStatus
}