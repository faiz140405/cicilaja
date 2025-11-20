<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\Payment;
use App\Exports\SubmissionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Untuk Excel
use Barryvdh\DomPDF\Facade\Pdf;      // <--- PENTING: Tambahkan Import Ini
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

        $totalApprovedCreditValue = Submission::where('status', 'approved')->sum('total_credit_amount');
        
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

    // Fungsi untuk Export data
    public function export(Request $request)
    {
        $format = $request->input('format', 'xlsx'); // Default ke xlsx
        $dateStr = now()->format('Ymd_His'); // Tambahkan jam agar nama file unik

        // SKENARIO 1: JIKA PDF (Gunakan DomPDF Langsung)
        if ($format === 'pdf') {
            
            // 1. Ambil Data (Sesuai query yang Anda butuhkan)
            $submissions = Submission::with(['user', 'product'])->get();

            // 2. Load View yang Anda simpan di: resources/views/pdf/submissions/report.blade.php
            // Perhatikan path-nya: 'pdf.submissions.report'
            $pdf = Pdf::loadView('pdf.submissions.report', compact('submissions'));

            // 3. (Opsional) Set Ukuran Kertas
            $pdf->setPaper('a4', 'portrait'); // Bisa ganti 'landscape' jika tabel lebar

            // 4. Download File
            $fileName = 'laporan_pengajuan_' . $dateStr . '.pdf';
            return $pdf->download($fileName);
        } 
        
        // SKENARIO 2: JIKA EXCEL (Gunakan Maatwebsite)
        else {
            $fileName = 'laporan_pengajuan_' . $dateStr . '.xlsx';
            return Excel::download(new SubmissionsExport, $fileName);
        }
    }
}