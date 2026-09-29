<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\JadwalTes;
use App\Models\Biodatamodel;
use App\Models\Pengaturan; 
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Dasar
        $totalAkun = User::count(); 
        $totalPendaftar = Pendaftaran::count();
        $totalLaki = Biodatamodel::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Biodatamodel::where('jenis_kelamin', 'Perempuan')->count();
        $totalDiverifikasi = Pendaftaran::where('status_verifikasi', 'berhasil')->count();
        $totalDitolak = Pendaftaran::where('status_verifikasi', 'ditolak')->count();
        $totalKelulusan = Pendaftaran::where('status_lulus', 'lulus')->count();

        // 2. Data Grafik Pendaftar (7 Hari Terakhir)
        $labels = [];
        $dataPendaftar = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->translatedFormat('l');
            $dataPendaftar[] = Pendaftaran::whereDate('created_at', $date->toDateString())->count();
        }

        // 3. Data Grafik Asal Sekolah
        $sekolahData = Biodatamodel::select('asal_sekolah', DB::raw('count(*) as total'))
                        ->groupBy('asal_sekolah')
                        ->get();
        
        // 4. 5 Pendaftar Terbaru
        $pendaftarTerbaru = Pendaftaran::with('user.biodata')->latest()->take(5)->get();

        // 5. Status Akses
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
    // KODE BARU: KELULUSAN & LAPORAN
    // ==========================================

    // Tampilkan Halaman Kelulusan Admin
    public function kelulusan()
    {
        // Hanya ambil data siswa yang sudah verifikasi berkas
        $pendaftarans = Pendaftaran::with('user.biodata')
                                   ->where('status_verifikasi', 'berhasil')
                                   ->latest()
                                   ->get();

        // Cek status tombol Buka/Tutup Pengumuman di database Pengaturan
        $statusKelulusan = (new Pengaturan)->setTable('pengaturan')
                            ->where('nama_pengaturan', 'status_kelulusan')
                            ->value('nilai') ?? 'tutup';

        return view('admin.kelulusan', compact('pendaftarans', 'statusKelulusan'));
    }

    // Update Status Kelulusan (Lulus / Tidak Lulus) per siswa
    public function updateKelulusan(Request $request, $id)
    {
        $request->validate([
            'status_lulus' => 'required|in:lulus,tidak_lulus,menunggu'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'status_lulus' => $request->status_lulus
        ]);

        return redirect()->back()->with('success', 'Status kelulusan siswa berhasil diperbarui!');
    }

    // Toggle (Buka/Tutup) Pengumuman Kelulusan Global
    public function toggleKelulusan(Request $request)
    {
        $request->validate(['status' => 'required|in:buka,tutup']);
        
        (new Pengaturan)->setTable('pengaturan')->updateOrCreate(
            ['nama_pengaturan' => 'status_kelulusan'], 
            ['nilai' => $request->status]
        );
        
        return redirect()->back()->with('success', 'Akses pengumuman kelulusan berhasil diperbarui!');
    }

    // Tampilkan Halaman Laporan Admin
    public function laporan(Request $request)
    {
        // Hitung ringkasan hasil seleksi untuk Dashboard Laporan Admin
        $totalSeleksi = Pendaftaran::where('status_verifikasi', 'berhasil')->count();
        $lulus = Pendaftaran::where('status_lulus', 'lulus')->count();
        $tidakLulus = Pendaftaran::where('status_lulus', 'tidak_lulus')->count();
        
        // Ambil list data untuk ditampilkan di tabel
        $pendaftarans = Pendaftaran::with('user.biodata')
                                   ->where('status_verifikasi', 'berhasil')
                                   ->latest()
                                   ->paginate(10); // Gunakan pagination agar rapi

        return view('admin.laporan', compact('totalSeleksi', 'lulus', 'tidakLulus', 'pendaftarans'));
    }

    // Method untuk cetak PDF Laporan
    public function cetakLaporanPdf()
    {
        // Fitur placeholder jika Anda sudah menginstall barryvdh/laravel-dompdf
        // $data = Pendaftaran::where('status_verifikasi', 'berhasil')->get();
        // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pdf.laporan', compact('data'));
        // return $pdf->download('Laporan_Kelulusan_SPMB.pdf');
        
        return redirect()->back()->with('info', 'Fitur cetak PDF laporan sedang disiapkan.');
    }

    // Method untuk export Excel Laporan
    public function exportLaporanExcel()
    {
        // Fitur placeholder jika Anda sudah menginstall maatwebsite/excel
        // return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LaporanExport, 'Laporan_Kelulusan.xlsx');
        
        return redirect()->back()->with('info', 'Fitur export Excel laporan sedang disiapkan.');
    }
}