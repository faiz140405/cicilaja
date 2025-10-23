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

    // Fungsi untuk Export data ke Excel
    public function export(Request $request)
    {
        $format = $request->input('format', 'xlsx'); // Default ke xlsx
        
        // PENTING: Gunakan format yang sesuai
        if ($format === 'pdf') {
            $fileName = 'laporan_pengajuan_' . now()->format('Ymd') . '.pdf';
            return Excel::download(new SubmissionsExport, $fileName, \Maatwebsite\Excel\Excel::DOMPDF); 
            
        } else {
            $fileName = 'laporan_pengajuan_' . now()->format('Ymd') . '.xlsx';
            return Excel::download(new SubmissionsExport, $fileName);
        }
    }
}