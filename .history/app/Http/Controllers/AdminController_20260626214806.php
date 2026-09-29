<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\JadwalTes;
use App\Models\Biodatamodel;
use App\Models\Pengaturan; 
use App\Models\User;
use App\Models\Notifikasi;
use App\Exports\PendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAkun = User::count(); 
        $totalPendaftar = Pendaftaran::count();
        $totalLaki = Biodatamodel::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Biodatamodel::where('jenis_kelamin', 'Perempuan')->count();
        $totalDiverifikasi = Pendaftaran::where('status_verifikasi', 'berhasil')->count();
        $totalDitolak = Pendaftaran::where('status_verifikasi', 'ditolak')->count();
        $totalKelulusan = Pendaftaran::where('status_lulus', 'lulus')->count();

        $labels = [];
        $dataPendaftar = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->translatedFormat('l');
            $dataPendaftar[] = Pendaftaran::whereDate('created_at', $date->toDateString())->count();
        }

        $sekolahData = Biodatamodel::select('asal_sekolah', DB::raw('count(*) as total'))
                        ->groupBy('asal_sekolah')
                        ->get();
        
        $pendaftarTerbaru = Pendaftaran::with('user.biodata')->latest()->take(5)->get();

        $statusPendaftaran = (new Pengaturan)->setTable('pengaturan')
                            ->where('nama_pengaturan', 'status_pendaftaran')
                            ->value('nilai') ?? 'buka';

        return view('admin.DashboardAdmin', compact(
            'totalAkun', 'totalPendaftar', 'totalLaki', 'totalPerempuan', 
            'totalDiverifikasi', 'totalDitolak', 'totalKelulusan',
            'labels', 'dataPendaftar', 'sekolahData', 'pendaftarTerbaru', 'statusPendaftaran'
        ));
    }

    public function pendaftaran()
    {
        $pendaftarans = Pendaftaran::whereHas('user')->with(['user.biodata'])->latest()->get();
        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function showBerkas($id)
    {
        $pendaftaran = Pendaftaran::with('user.biodata')->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftaran'));
    }

    public function detailPendaftar($id)
    {
        $pendaftaran = Pendaftaran::with(['user.biodata'])->findOrFail($id);
        return view('admin.detail_pendaftar', compact('pendaftaran'));
    }

    public function verifikasiBerkas(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_verifikasi' => $request->status, 
            'catatan_verifikasi' => $request->catatan_verifikasi
        ]);
        return redirect()->route('admin.pendaftaran')->with('success', 'Status dan Catatan pendaftar berhasil diperbarui!');
    }

    public function inputJadwalTes(Request $request, $id)
    {
        $request->validate(['tanggal_tes' => 'required|date', 'waktu_tes' => 'required', 'ruangan_atau_tempat' => 'required|string']);
        JadwalTes::updateOrCreate(['user_id' => $id], $request->except('_token'));
        return redirect()->back()->with('success', 'Jadwal tes berhasil diset.');
    }

    public function inputKelulusan(Request $request, $id)
    {
        $request->validate(['status_lulus' => 'required|in:lulus,tidak_lulus']);
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($request->only('status_lulus', 'catatan_lulus'));
        return redirect()->back()->with('success', 'Status kelulusan berhasil ditetapkan.');
    }

    public function pengaturan()
    {
        $statusPendaftaran = Pengaturan::where('nama_pengaturan', 'status_pendaftaran')->first();
        return view('admin.pengaturan.index', compact('statusPendaftaran'));
    }

    public function updatePengaturan(Request $request)
    {
        $request->validate(['nilai' => 'required|in:buka,tutup']);
        Pengaturan::updateOrCreate(['nama_pengaturan' => 'status_pendaftaran'], ['nilai' => $request->nilai]);
        return redirect()->back()->with('success', 'Status pendaftaran berhasil diubah.');
    }

    public function hapusPendaftar($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        Storage::disk('public')->deleteDirectory('berkas_pendaftar/' . $pendaftaran->user_id);
        $pendaftaran->delete();
        return redirect()->back()->with('success', 'Data pendaftar berhasil dihapus.');
    }

    public function togglePendaftaran(Request $request)
    {
        $request->validate(['status' => 'required|in:buka,tutup']);
        (new Pengaturan)->setTable('pengaturan')->updateOrCreate(['nama_pengaturan' => 'status_pendaftaran'], ['nilai' => $request->status]);
        return redirect()->back()->with('success', 'Status akses pendaftaran berhasil diperbarui!');
    }

    public function akunPendaftar()
    {
        $akuns = User::with('biodata')->orderBy('created_at', 'desc')->get();
        return view('admin.akun', compact('akuns'));
    }

    public function hapusAkun($id)
    {
        $user = User::findOrFail($id);
        Storage::disk('public')->deleteDirectory('berkas_pendaftar/' . $user->id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun pendaftar berhasil dihapus permanen.');
    }

    // ==========================================
    // KELULUSAN & LAPORAN
    // ==========================================

    public function kelulusan()
    {
        $pendaftarans = Pendaftaran::with('user.biodata')
                                   ->where('status_verifikasi', 'berhasil')
                                   ->latest()
                                   ->get();

        $pengaturan = Pengaturan::where('nama_pengaturan', 'status_kelulusan')->first();
        $statusKelulusan = $pengaturan ? $pengaturan->nilai : 'tutup';
        $waktuDibuka = $pengaturan ? $pengaturan->waktu_dibuka : null;

        return view('admin.kelulusan', compact('pendaftarans', 'statusKelulusan', 'waktuDibuka'));
    }

    public function updateKelulusan(Request $request, $id)
    {
        $request->validate(['status_lulus' => 'required|in:lulus,tidak_lulus,menunggu']);
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status_lulus' => $request->status_lulus]);
        return redirect()->back()->with('success', 'Status kelulusan siswa berhasil diperbarui!');
    }

    public function toggleKelulusan(Request $request)
    {
        $request->validate(['status' => 'required|in:buka,tutup']);
        
        $data = ['nilai' => $request->status];
        if ($request->status == 'buka') {
            $data['waktu_dibuka'] = now();
        }

        Pengaturan::updateOrCreate(
            ['nama_pengaturan' => 'status_kelulusan'], 
            $data
        );
        return redirect()->back()->with('success', 'Akses pengumuman kelulusan berhasil diperbarui!');
    }

    public function kirimNotifikasi(Request $request, $user_id)
    {
        $pendaftaran = Pendaftaran::where('user_id', $user_id)->firstOrFail();
        
        Notifikasi::updateOrCreate(
            ['user_id' => $user_id],
            [
                'pesan' => $pendaftaran->status_lulus == 'lulus' ? 'Selamat, Anda dinyatakan Lulus!' : 'Mohon maaf, Anda dinyatakan Tidak Lulus.',
                'status_lulus' => $pendaftaran->status_lulus
            ]
        );
        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ke siswa!');
    }

    public function laporan(Request $request)
    {
        $query = Pendaftaran::with('user.biodata');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [$request->tanggal_awal.' 00:00:00', $request->tanggal_akhir.' 23:59:59']);
        }
        
        if ($request->filled('status_verifikasi') && $request->status_verifikasi !== 'Semua') {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
        
        if ($request->filled('status_kelulusan') && $request->status_kelulusan !== 'Semua') {
            $query->where('status_lulus', $request->status_kelulusan);
        }

        $filteredData = $query->get();
        $totalPendaftar = $filteredData->count();
        $diverifikasi = $filteredData->where('status_verifikasi', 'berhasil')->count();
        $ditolak = $filteredData->where('status_verifikasi', 'ditolak')->count();
        $lulus = $filteredData->where('status_lulus', 'lulus')->count();
        $tidakLulus = $filteredData->where('status_lulus', 'tidak_lulus')->count();

        $belumVerif = $filteredData->where('status_verifikasi', 'belum_diperiksa')->count();
        $menungguLulus = $filteredData->where('status_lulus', 'menunggu')->count();
        
        $chartVerif = [$diverifikasi, $ditolak, $belumVerif]; 
        $chartLulus = [$lulus, $tidakLulus, $menungguLulus];  

        $tahunIni = date('Y');
        $chartBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartBulan[] = Pendaftaran::whereMonth('created_at', $i)->whereYear('created_at', $tahunIni)->count();
        }

        $pendaftarans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.laporan', compact(
            'totalPendaftar', 'diverifikasi', 'ditolak', 'lulus', 'tidakLulus',
            'chartVerif', 'chartLulus', 'chartBulan', 'pendaftarans'
        ));
    }

    // --- PERBAIKAN: Menambahkan Request $request ---
    public function cetakLaporanPdf(Request $request)
    {
        $query = Pendaftaran::with('user.biodata');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [$request->tanggal_awal.' 00:00:00', $request->tanggal_akhir.' 23:59:59']);
        }
        if ($request->filled('status_verifikasi') && $request->status_verifikasi !== 'Semua') {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
        if ($request->filled('status_kelulusan') && $request->status_kelulusan !== 'Semua') {
            $query->where('status_lulus', $request->status_kelulusan);
        }

        $pendaftarans = $query->get();
        $pdf = Pdf::loadView('admin.pdf.laporan', compact('pendaftarans'));
        return $pdf->download('Laporan_Pendaftar_SPMB.pdf');
    }

    public function exportLaporanExcel(Request $request)
    {
        $query = Pendaftaran::with('user.biodata');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [$request->tanggal_awal.' 00:00:00', $request->tanggal_akhir.' 23:59:59']);
        }
        if ($request->filled('status_verifikasi') && $request->status_verifikasi !== 'Semua') {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }
        if ($request->filled('status_kelulusan') && $request->status_kelulusan !== 'Semua') {
            $query->where('status_lulus', $request->status_kelulusan);
        }

        return Excel::download(new PendaftaranExport($query->get()), 'Laporan_Pendaftar_SPMB.xlsx');
    }
}