<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Product;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Hanya ambil submissions yang approved
        $submissions = $user->submissions()->with('product', 'payments')->where('status', 'approved')->latest()->get();
        $availableProducts = Product::with('category')->where('stock', '>', 0)->latest()->limit(4)->get(); // Ambil 4 produk saja

        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        $data = $this->calculateFinancialSummary($submissions);

        // LOGIKA KETERLAMBATAN DAN DENDA
        $dueDate = Carbon::now()->startOfMonth(); 
        $isLate = false;
        $daysLate = 0;
        $totalPenalty = 0;
        
        $today = Carbon::now();
        $penaltyRate = 5000;
        
        // Iterasi dan cek denda per submission yang telat
        foreach ($submissions as $submission) {
            $firstDueDate = Carbon::parse($submission->created_at)
                ->addMonth()
                ->day(1)
                ->startOfDay();
            
            $periodsCompleted = $submission->payments()->where('status', 'verified')->count();
            $targetPeriod = $periodsCompleted + 1;

            if ($targetPeriod <= $submission->tenor) { // Hanya cek jika periode masih dalam tenor
                $periodDueDate = $firstDueDate->copy()->addMonths($targetPeriod - 1);
                
                // Cek apakah periode ini sudah lewat dan belum ada pembayaran verified/pending
                $isPaidOrPending = $submission->payments->whereIn('status', ['verified', 'pending'])->where('period', $targetPeriod)->count();
                
                if ($today->greaterThan($periodDueDate) && !$isPaidOrPending) {
                    $isLate = true;
                    
                    // Hitung hari telat: Hari ini - Tanggal Jatuh Tempo
                    $daysLate = $today->diffInDays($periodDueDate);
                    
                    // Akumulasi denda (diasumsikan denda dihitung per pengajuan yang telat)
                    $totalPenalty += $daysLate * $penaltyRate; 
                }
            }
        }
        
        // DATA CHART (Dikompilasi untuk View)
        $progressChartData = [
            'lunas' => $data['total_periods_completed'],
            'tersisa' => $data['total_periods_left'],
        ];

        // FINAL RETURN VIEW
        return view('user.dashboard', compact(
            'submissions', 
            'paymentMethods', 
            'data', 
            'isLate', 
            'daysLate', 
            'totalPenalty', 
            'dueDate',
            'progressChartData', // Variabel ini sudah dimasukkan
            'availableProducts'
        ));
    }
    
    // METHOD UNTUK MENGHITUNG RINGKASAN FINANSIAL
    private function calculateFinancialSummary($submissions)
    {
        $totalItemsPrice = 0;
        $totalPaid = 0;
        $totalInstallmentsDue = 0;
        $totalPeriodsLeft = 0;
        $totalPeriodsCompleted = 0;

        foreach ($submissions as $submission) {
            if ($submission->status === 'approved') {
                $totalItemsPrice += $submission->product->credit_price;
                $periodsCompleted = $submission->payments()->where('status', 'verified')->count();
                
                $totalPeriodsCompleted += $periodsCompleted;
                $totalPeriodsLeft += $submission->tenor - $periodsCompleted;

                $amountPaid = ($submission->monthly_installment * $periodsCompleted) + $submission->down_payment;
                $totalPaid += $amountPaid;

                $totalInstallmentsDue += $submission->total_credit_amount;
            }
        }
        
        $totalDebtRemaining = $totalInstallmentsDue - ($totalPaid - $submissions->sum('down_payment'));
        
        $totalPeriods = $submissions->sum('tenor');
        $paymentProgress = $totalPeriods > 0 ? ($totalPeriodsCompleted / $totalPeriods) * 100 : 0;

        return [
            'total_items_price' => $totalItemsPrice,
            'total_paid' => $totalPaid,
            'total_debt_remaining' => max(0, $totalDebtRemaining),
            'total_periods_left' => $totalPeriodsLeft,
            'payment_progress' => round($paymentProgress, 1),
            'total_installments_due' => $totalInstallmentsDue,
            'total_periods_completed' => $totalPeriodsCompleted,
        ];
    }
}