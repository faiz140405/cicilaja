<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Payment;
use App\Exports\SubmissionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Tampilkan halaman laporan dengan metrik
    public function index()
    {
        // 1. Total Pengajuan
        $totalSubmissions = Submission::count();
        $approvedSubmissions = Submission::where('status', 'approved')->count();
        $rejectedSubmissions = Submission::where('status', 'rejected')->count();

        // 2. Total Nilai Kredit (dari pengajuan yang disetujui)
        $totalApprovedCreditValue = Submission::where('status', 'approved')->sum('total_credit_amount');

        // 3. Jumlah Tunggakan (Sederhana: pembayaran yang jatuh tempo > 30 hari dan belum verified)
        // Catatan: Implementasi tunggakan yang akurat sangat kompleks dan butuh tabel schedules.
        // Kita hitung jumlah pembayaran pending/rejected yang sudah lewat tanggal pengajuan + tenor bulan.
        
        $overduePayments = Payment::whereIn('status', ['due', 'rejected', 'pending'])
                                  ->whereDate('created_at', '<=', Carbon::now()->subDays(30))
                                  ->count();
        
        $metrics = [
            'total_submissions' => $totalSubmissions,
            'approved_submissions' => $approvedSubmissions,
            'rejected_submissions' => $rejectedSubmissions,
            'total_credit_value' => $totalApprovedCreditValue,
            'overdue_count' => $overduePayments,
        ];

        return view('admin.reports.index', compact('metrics'));
    }

    // Fungsi untuk Export data ke Excel
    public function export(Request $request)
    {
        // Untuk ekspor PDF, ganti 'xlsx' menjadi 'pdf'
        $format = $request->input('format', 'xlsx'); 
        $fileName = 'laporan_kredit_' . now()->format('Ymd_His') . '.' . $format;
        
        // Catatan: Export ke PDF memerlukan instalasi driver DomPDF/MPDF. 
        // Untuk kemudahan, kita fokus ke Excel (xlsx).
        
        return Excel::download(new SubmissionsExport, $fileName);
    }
}