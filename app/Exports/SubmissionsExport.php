<?php

namespace App\Exports;

use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SubmissionsExport implements FromView
{
    public function view(): View
    {
        // Ambil semua data pengajuan dengan eager loading user dan product
        $submissions = Submission::with(['user', 'product'])->get();

        // Gunakan view yang baru dibuat
        return view('pdf.submissions.report', [
            'submissions' => $submissions
        ]);
    }
}