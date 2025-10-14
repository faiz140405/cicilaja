<?php

namespace App\Exports;

use App\Models\Submission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubmissionsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Ambil data dari database.
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua data pengajuan dengan detail user dan produk
        return Submission::with(['user', 'product'])->get();
    }

    /**
     * Definisikan judul kolom (header) untuk file Excel/PDF.
     */
    public function headings(): array
    {
        return [
            'ID Pengajuan',
            'Tanggal Diajukan',
            'Pemohon (User)',
            'Email Pemohon',
            'Produk',
            'Harga Kredit Produk',
            'Uang Muka (DP)',
            'Tenor (Bulan)',
            'Cicilan Bulanan',
            'Total Hutang',
            'Status Pengajuan',
        ];
    }

    /**
     * Map data Eloquent ke baris yang sesuai dengan headings.
     */
    public function map($submission): array
    {
        return [
            $submission->id,
            $submission->created_at->format('d M Y'),
            $submission->user->name ?? 'N/A',
            $submission->user->email ?? 'N/A',
            $submission->product->name ?? 'Produk Dihapus',
            $submission->product->credit_price ?? 0,
            $submission->down_payment,
            $submission->tenor,
            $submission->monthly_installment,
            $submission->total_credit_amount,
            ucfirst($submission->status),
        ];
    }
}