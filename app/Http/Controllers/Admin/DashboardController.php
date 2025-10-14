<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Submission;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Ringkasan Utama (Metrik tetap dipertahankan)
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_submissions' => Submission::where('status', 'pending')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];
        
        // 2. Data untuk Chart (Status Pengajuan)
        $submissionStatuses = Submission::select('status')
            ->selectRaw('count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 3. Data Chart yang sudah diformat
        $chartData = [
            'labels' => ['Pending', 'Approved', 'Rejected'],
            'data' => [
                $submissionStatuses['pending'] ?? 0,
                $submissionStatuses['approved'] ?? 0,
                $submissionStatuses['rejected'] ?? 0,
            ],
            'colors' => ['#facc15', '#10b981', '#ef4444'], // Yellow, Green, Red
        ];


        // 4. Transaksi Terbaru
        $latestSubmissions = Submission::with('user', 'product')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'latestSubmissions', 'chartData'));
    }
}