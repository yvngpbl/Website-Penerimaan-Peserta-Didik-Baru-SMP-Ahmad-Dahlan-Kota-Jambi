<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\JadwalTes;
use App\Models\Biodata;

class AdminSpmbController extends Controller
{
    public function dashboard()
    {
        $totalPendaftar = Pendaftaran::count();
        $belumVerifikasi = Pendaftaran::where('status_verifikasi', 'belum_diperiksa')->count();
        $lulus = Pendaftaran::where('status_lulus', 'lulus')->count();

        return view('admin.dashboard', compact('totalPendaftar', 'belumVerifikasi', 'lulus'));
    }

    public function indexPendaftar()
    {
        // Ambil data pendaftaran beserta relasi user dan biodatanya
        $pendaftarans = Pendaftaran::with(['user.biodata'])->latest()->get();
        return view('admin.pendaftar.index', compact('pendaftarans'));
    }

    public function showBerkas($id)
    {
        $pendaftaran = Pendaftaran::with('user.biodata')->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftaran'));
    }

    public function verifikasiBerkas(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:berhasil,ditolak',
            'catatan_verifikasi' => 'nullable|string'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ]);

        return redirect()->back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function inputJadwalTes(Request $request, $id)
    {
        // $id di sini adalah user_id dari siswa yang bersangkutan
        $request->validate([
            'tanggal_tes' => 'required|date',
            'waktu_tes' => 'required',
            'ruangan_atau_tempat' => 'required|string',
            'catatan_tambahan' => 'nullable|string'
        ]);

        JadwalTes::updateOrCreate(
            ['user_id' => $id],
            [
                'tanggal_tes' => $request->tanggal_tes,
                'waktu_tes' => $request->waktu_tes,
                'ruangan_atau_tempat' => $request->ruangan_atau_tempat,
                'catatan_tambahan' => $request->catatan_tambahan,
            ]
        );

        return redirect()->back()->with('success', 'Jadwal tes berhasil diset.');
    }

    public function inputKelulusan(Request $request, $id)
    {
        $request->validate([
            'status_lulus' => 'required|in:lulus,tidak_lulus',
            'catatan_lulus' => 'nullable|string'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_lulus' => $request->status_lulus,
            'catatan_lulus' => $request->catatan_lulus,
        ]);

        return redirect()->back()->with('success', 'Status kelulusan berhasil ditetapkan.');
    }
}