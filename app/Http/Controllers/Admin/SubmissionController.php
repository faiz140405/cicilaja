<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;


class SubmissionController extends Controller
{
    // READ: Tampilkan daftar semua pengajuan
    public function index(Request $request)
    {
        $query = Submission::with(['user', 'product']);
        $search = $request->get('search'); // Ambil query pencarian

        if ($search) {
            // Logic pencarian: Cari di kolom name, email, phone_number, atau address user
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%")
                               ->orWhere('phone_number', 'like', "%{$search}%")
                               ->orWhere('address', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function ($subQuery) use ($search) {
                      $subQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        $submissions = $query->latest()->paginate(10);
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
        if (in_array($submission->status, ['approved', 'rejected', 'fully_paid', 'pending_payoff'])) { 
             // Izinkan hanya jika pending_payoff untuk diproses lebih lanjut
             if ($submission->status !== 'pending_payoff') {
                 return redirect()->route('admin.submissions.index')->with('error', 'Pengajuan sudah diproses.');
             }
        }

        // --- LOGIKA UTAMA (Sama seperti updateStatus sebelumnya) ---

        if ($statusToSet === 'verified' && $submission->status === 'pending_payoff') {
            
            // Tentukan periode terakhir yang sudah lunas (verified)
            $lastVerifiedPeriod = $submission->payments()->where('status', 'verified')->max('period') ?? 0;
            
            // Loop semua periode yang tersisa, dimulai dari periode berikutnya
            for ($i = $lastVerifiedPeriod + 1; $i <= $submission->tenor; $i++) {
                
                // Cari atau buat row payment untuk periode ini
                Payment::updateOrCreate(
                    [
                        'submission_id' => $submission->id,
                        'period' => $i,
                    ],
                    [
                        'amount_paid' => $submission->monthly_installment, // Nilai cicilan bulanan biasa (untuk data)
                        'proof_path' => 'SYSTEM_PAYOFF', // Mark dengan string khusus
                        'payment_date' => Carbon::now(),
                        'status' => 'verified', // Set ke LUNAS
                        'created_at' => Carbon::now(),
                    ]
                );
            }
            
            // Set status submission menjadi LUNAS FINAL
            $submission->status = 'fully_paid'; 
            $submission->save();
            
            // Cari dan set row 'pending_payoff' yang asli menjadi verified juga
            Payment::where('submission_id', $submission->id)
                   ->where('status', 'pending_payoff')
                   ->update(['status' => 'verified']);

            $message = 'Pelunasan Dipercepat berhasil diverifikasi. Pengajuan Dinyatakan LUNAS!';
        
        // 2. Verifikasi pengajuan awal ('pending')
        } elseif ($statusToSet === 'approved' || $statusToSet === 'rejected') {
            
            $submission->status = $statusToSet;
            $submission->save();
            $message = ($statusToSet === 'approved') ? 'Pengajuan berhasil disetujui!' : 'Pengajuan ditolak.';
        } else {
             $message = 'Aksi tidak valid.';
        }
        
        return redirect()->route('admin.submissions.index')
                         ->with('success', $message);
    }
}