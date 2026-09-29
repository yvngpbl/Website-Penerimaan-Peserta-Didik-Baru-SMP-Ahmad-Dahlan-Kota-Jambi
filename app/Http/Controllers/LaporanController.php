<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function cetakPdf(Request $request)
    {
        // Bisa difilter berdasarkan input dari view (misal: yg lulus saja)
        $query = Pendaftaran::with('user.biodata');

        if ($request->has('status_lulus') && $request->status_lulus != 'semua') {
            $query->where('status_lulus', $request->status_lulus);
        }

        $dataPendaftar = $query->get();

        $pdf = Pdf::loadView('pdf.laporan_pendaftar', compact('dataPendaftar'))->setPaper('a4', 'landscape');
        
        return $pdf->download('Laporan_SPMB_Ahmad_Dahlan.pdf');
    }
}