<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendaftaranExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection() {
        return $this->data->map(function($pd, $index) {
            return [
                $index + 1,
                $pd->user->biodata->nama_lengkap ?? '-',
                $pd->user->biodata->nisn ?? '-',
                $pd->user->biodata->asal_sekolah ?? '-',
                $pd->created_at->format('d/m/Y'),
                $pd->kriteria,
                $pd->status_verifikasi,
                $pd->status_lulus ?? '-'
            ];
        });
    }

    public function headings(): array {
        return ["No", "Nama", "NISN", "Asal Sekolah", "Tanggal Daftar", "Jalur", "Status Verifikasi", "Status Kelulusan"];
    }
}