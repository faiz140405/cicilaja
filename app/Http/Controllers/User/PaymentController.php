<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Payment;

class PaymentController extends Controller
{
        // Tampilkan daftar cicilan yang harus dibayar
    public function index()
    {
        $approvedSubmissions = Auth::user()->submissions()
            ->where('status', 'approved')
            ->with('product', 'payments')
            ->get();
            
        $installments = $this->generateInstallmentsList($approvedSubmissions);

        return view('user.payments.index', compact('installments'));
    }

    // Fungsi bantu untuk menghasilkan daftar cicilan yang terstruktur
    protected function generateInstallmentsList($submissions)
    {
        $installments = [];
        $today = Carbon::now();
        $paymentWindowStartDay = 20; // Mulai pengingat/jendela pembayaran

        foreach ($submissions as $submission) {
            
            // Hitung tanggal jatuh tempo pertama (tanggal 1 bulan depan dari approval)
            $firstDueDate = Carbon::parse($submission->created_at)
                ->addMonth()
                ->day(1)
                ->startOfDay();

            $verifiedPayments = $submission->payments()->where('status', 'verified')->count();
            $totalPeriods = $submission->tenor;
            $monthlyAmount = $submission->monthly_installment;
            
            // Buat daftar cicilan bulanan
            $periods = [];
            for ($i = 1; $i <= $totalPeriods; $i++) {
                $payment = $submission->payments->firstWhere('period', $i);
                $periodDueDate = $firstDueDate->copy()->addMonths($i - 1);
                
                $status = 'upcoming'; // Default
                $daysLate = 0;
                $penalty = 0;

                if ($payment) {
                    $status = $payment->status; // verified, pending, rejected
                } elseif ($today->greaterThan($periodDueDate)) {
                    // 1. TERLAMBAT (LATE)
                    $status = 'late';
                    $daysLate = $today->diffInDays($periodDueDate);
                    $penalty = $daysLate * 5000;
                } elseif ($today->greaterThanOrEqualTo($periodDueDate->copy()->subMonth()->day($paymentWindowStartDay)) && $today->lessThan($periodDueDate)) {
                    // 2. JATUH TEMPO (DUE/REMINDER) - Mulai tgl 20 bulan sebelumnya s/d tgl 1
                    $status = 'due';
                    $daysRemaining = $today->diffInDays($periodDueDate); // Untuk reminder
                }
                // 3. AKAN DATANG (UPCOMING) - Default status tetap 'upcoming'

                $periods[] = [
                    'period_number' => $i,
                    'amount' => $monthlyAmount,
                    'due_date' => $periodDueDate, // Kirim tanggal jatuh tempo
                    'status' => $status, 
                    'days_late' => $daysLate,
                    'penalty' => $penalty,
                    'payment_id' => $payment ? $payment->id : null,
                ];
            }
            
            $installments[] = [
                'submission' => $submission,
                'periods' => $periods,
                'periods_left' => $totalPeriods - $verifiedPayments,
            ];
        }
        return $installments;
    }

    // Simpan bukti pembayaran baru
    public function store(Request $request, Submission $submission)
    {
        $request->validate([
            'period' => 'required|integer|min:1|max:' . $submission->tenor,
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ]);

        // Cek apakah pembayaran untuk periode ini sudah diverifikasi
        $existingPayment = $submission->payments()->where('period', $request->period)->first();
        if ($existingPayment && $existingPayment->status === 'verified') {
            return back()->with('error', 'Cicilan periode ini sudah lunas.');
        }

        // --- METODE NON-SYMLINK (Penyimpanan di public/) ---
        $imageFile = $request->file('proof');
        $fileName = time() . '_' . $imageFile->getClientOriginalName();
        $destinationPath = public_path('uploaded_images/proofs');
        
        // Buat folder jika belum ada
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        // Pindahkan file ke folder public/uploaded_images/proofs
        $imageFile->move($destinationPath, $fileName);
        $proofPath = 'uploaded_images/proofs/' . $fileName; // Path relatif ke public

        // Buat atau update pembayaran
        $submission->payments()->updateOrCreate(
            ['period' => $request->period],
            [
                'amount_paid' => $submission->monthly_installment,
                'proof_path' => $proofPath, // <-- SIMPAN PATH BARU
                'payment_date' => Carbon::now(),
                'status' => 'pending', 
                'created_at' => Carbon::now(),
            ]
        );
        
        return back()->with('success', 'Bukti pembayaran untuk periode ' . $request->period . ' berhasil diunggah. Menunggu verifikasi Admin.');
    }
    public function acceleratedStore(Request $request, Submission $submission)
    {
        // 1. Validasi Input (Sudah ada)
        $validated = $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'amount' => 'required|integer|min:1', 
            'is_full_payoff' => 'required|in:1', 
        ]);

        $imageFile = $request->file('proof');
        $fileName = time() . '_payoff_' . $imageFile->getClientOriginalName();
        $destinationPath = public_path('uploaded_images/proofs');
        
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        $imageFile->move($destinationPath, $fileName);
        $proofPath = 'uploaded_images/proofs/' . $fileName; // Path relatif ke public
        // --- END METODE NON-SYMLINK ---

        // 4. Catat Pembayaran dengan Status Khusus
        $nextPeriod = $submission->payments()->where('status', 'verified')->count() + 1;

        Payment::updateOrCreate(
            [
                'submission_id' => $submission->id,
                'period' => $nextPeriod, 
            ],
            [
                'amount_paid' => $validated['amount'], 
                'proof_path' => $proofPath, // <-- SIMPAN PATH BARU
                'payment_date' => Carbon::now(),
                'status' => 'pending_payoff',
                'created_at' => Carbon::now(),
            ]
        );

        // 5. Update Status Pengajuan menjadi pending_payoff
        $submission->status = 'pending_payoff';
        $submission->save();


        return redirect()->route('user.dashboard')
                         ->with('success', 'Pengajuan pelunasan dipercepat untuk ' . $submission->product->name . ' berhasil dikirim. Menunggu verifikasi Admin.');
    }
}