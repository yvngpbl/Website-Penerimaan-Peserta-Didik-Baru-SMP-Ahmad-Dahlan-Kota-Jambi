<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeSpmb;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = PeriodeSpmb::latest()->get();
        return view('admin.periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20',
            'tanggal_buka' => 'required|date',
            'tanggal_tutup' => 'required|date|after_or_equal:tanggal_buka',
            'kuota_penerimaan' => 'nullable|integer',
        ]);

        PeriodeSpmb::create($request->all());
        return redirect()->back()->with('success', 'Periode baru berhasil ditambahkan.');
    }

    public function toggleStatus($id)
    {
        $periode = PeriodeSpmb::findOrFail($id);

        // Jika akan diaktifkan, matikan semua periode lain dulu
        if (!$periode->status_aktif) {
            PeriodeSpmb::query()->update(['status_aktif' => false]);
            $periode->update(['status_aktif' => true]);
        } else {
            // Jika mematikan periode yang sedang aktif
            $periode->update(['status_aktif' => false]);
        }

        return redirect()->back()->with('success', 'Status periode berhasil diubah.');
    }
}