<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeSpmb;

class LandingPageController extends Controller
{
    public function index()
    {
        // Cari periode yang sedang aktif (hanya 1)
        $periodeAktif = PeriodeSpmb::where('status_aktif', true)->first();
        
        $pendaftaranBuka = false;
        
        // Logika cek apakah hari ini masih dalam rentang waktu pendaftaran
        if ($periodeAktif) {
            $hariIni = now()->format('Y-m-d');
            if ($hariIni >= $periodeAktif->tanggal_buka && $hariIni <= $periodeAktif->tanggal_tutup) {
                $pendaftaranBuka = true;
            }
        }

        return view('welcome', compact('periodeAktif', 'pendaftaranBuka'));
    }
}