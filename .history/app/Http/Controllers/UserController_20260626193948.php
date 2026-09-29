<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biodatamodel;
use App\Models\Pendaftaran;
use App\Models\JadwalTes;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $biodata = $user->biodata;
        $pendaftaran = $user->pendaftaran;
        
        return view('user.DashboardUser', compact('biodata', 'pendaftaran'));
    }

    public function pendaftaran()
    {
        // Memaksa Eloquent menggunakan nama tabel tunggal 'pengaturan' secara inline
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_pendaftaran')->first();
        $status = $pengaturan ? $pengaturan->nilai : 'tutup';
        $user = Auth::user();

        return view('user.pendaftaran', compact('status', 'user'));
    }

    public function storePendaftaran(Request $request)
    {
        // --- PROTEKSI TAMBAHAN: CEK STATUS PENDAFTARAN SEBELUM MENYIMPAN ---
        // Memaksa Eloquent menggunakan nama tabel tunggal 'pengaturan' secara inline
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_pendaftaran')->first();
        $status = $pengaturan ? $pengaturan->nilai : 'tutup';
        
        if ($status === 'tutup') {
            return redirect()->route('user.pendaftaran')->with('error', 'Mohon maaf, pendaftaran saat ini telah ditutup oleh panitia.');
        }
        // ------------------------------------------------------------------

        $request->validate([
            // Biodata & Data Orang Tua
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'nisn' => 'nullable|string',
            'nik' => 'nullable|string',
            'asal_sekolah' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'nullable|numeric',
            'tinggal_bersama' => 'nullable|string',
            'moda_transportasi' => 'nullable|string',
            'alamat' => 'required|string',
            
            // Data Periodik
            'tinggi_badan' => 'nullable|numeric',
            'berat_badan' => 'nullable|numeric',
            'jumlah_saudara' => 'nullable|numeric',

            // Data Ayah & Ibu
            'nama_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'no_hp_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string',

            // Kriteria & Berkas
            'kriteria' => 'required',
            'file_raport' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_skl' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_akte' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => 'nullable|image|max:2048',
            'bukti_pembayaran' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user_id = Auth::id();

        // A. Simpan ke tabel Biodata
        Biodatamodel::updateOrCreate(
            ['user_id' => $user_id],
            $request->only([
                'nama_lengkap', 'jenis_kelamin', 'nisn', 'nik', 'asal_sekolah', 
                'tempat_lahir', 'tanggal_lahir', 'alamat', 'tinggal_bersama', 
                'moda_transportasi', 'anak_ke', 'tinggi_badan', 'berat_badan', 
                'jumlah_saudara', 'nama_ayah', 'tempat_lahir_ayah', 'pendidikan_ayah', 
                'pekerjaan_ayah', 'penghasilan_ayah', 'no_hp_ayah', 'nama_ibu', 
                'tempat_lahir_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 
                'penghasilan_ibu', 'no_hp_ibu'
            ])
        );

        // B. Persiapan data tabel Pendaftaran
        $path = 'berkas_pendaftar/' . $user_id;
        $dataPendaftaran = [
            'user_id' => $user_id,
            'kriteria' => $request->kriteria,
            'status_verifikasi' => 'belum_diperiksa',
        ];

        // C. Simpan Berkas Fisik
        $files = [
            'file_raport', 'file_skl', 'file_akte', 'file_kk', 'file_ijazah', 
            'pas_foto', 'ktp_ortu', 'file_keterangan_sehat', 
            'file_keterangan_yatim', 'file_piagam', 'bukti_pembayaran'
        ];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $dataPendaftaran[$file] = $request->file($file)->store($path, 'public');
            }
        }

        Pendaftaran::updateOrCreate(
            ['user_id' => $user_id],
            $dataPendaftaran
        );

        return redirect()->route('user.pendaftaran.tambahan')->with('info', 'Data berhasil disimpan, silakan isi formulir persetujuan dan tanda tangan.');
    }

    public function tambahan()
    {
        $user = Auth::user();
        $pendaftaran = $user->pendaftaran;
        $biodata = $user->biodata;

        if (!$pendaftaran) {
            return redirect()->route('user.pendaftaran')->with('error', 'Silakan isi formulir pendaftaran utama terlebih dahulu.');
        }

        return view('user.formulirtambahan', compact('pendaftaran', 'biodata'));
    }

    public function storeTambahan(Request $request)
    {
        $request->validate([
            'setuju_biaya' => 'required',
            'setuju_peraturan' => 'required',
            'ttd_orang_tua' => 'required',
            'ttd_siswa' => 'required',
            'ttl_manual' => 'required|string',
            'alamat_manual' => 'required|string',
            'no_hp_ortu' => 'required|string',
        ]);

        $user_id = Auth::id();
        $pendaftaran = Pendaftaran::where('user_id', $user_id)->firstOrFail();

        $dataUpdate = [
            'setuju_biaya' => $request->setuju_biaya,
            'setuju_peraturan' => $request->setuju_peraturan,
            'tgl_persetujuan' => now(),
            
            // Pindahkan data dari input manual ke kolom database
            'ttl_siswa' => $request->ttl_manual, 
            'alamat_lengkap' => $request->alamat_manual,
            'no_hp_ortu' => $request->no_hp_ortu,
        ];

        $ttdPath = 'signatures/' . $user_id;
        if (!Storage::disk('public')->exists($ttdPath)) {
            Storage::disk('public')->makeDirectory($ttdPath, 0755, true);
        }

        // Simpan Tanda Tangan Orang Tua ke kolom 'ttd_ayah' sesuai database
        if ($request->filled('ttd_orang_tua')) {
            $data = $request->input('ttd_orang_tua');
            $image = str_replace('data:image/png;base64,', '', $data);
            $image = str_replace(' ', '+', $image);
            $imageName = 'ttd_orang_tua_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, base64_decode($image));
            $dataUpdate['ttd_ayah'] = $ttdPath . '/' . $imageName;
        }

        // Simpan Tanda Tangan Siswa ke kolom 'ttd_siswa'
        if ($request->filled('ttd_siswa')) {
            $data = $request->input('ttd_siswa');
            $image = str_replace('data:image/png;base64,', '', $data);
            $image = str_replace(' ', '+', $image);
            $imageName = 'ttd_siswa_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, base64_decode($image));
            $dataUpdate['ttd_siswa'] = $ttdPath . '/' . $imageName;
        }

        $pendaftaran->update($dataUpdate);

        return redirect()->route('user.riwayat')
                     ->with('success', 'Formulir pernyataan berhasil disimpan!');
    }

    public function riwayat()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->with('user.biodata')
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('user.pendaftaran')->with('info', 'Anda belum melakukan pendaftaran.');
        }

        return view('user.riwayat', compact('pendaftaran'));
    }

    // --- FUNGSI BARU: DOWNLOAD PDF PERNYATAAN ---
    public function downloadPernyataanPDF()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->firstOrFail();
        $biodata = $user->biodata;

        $data = [
            'pendaftaran' => $pendaftaran,
            'biodata'     => $biodata,
            'tgl_cetak'   => now()->translatedFormat('d F Y'),
        ];

        // Memanggil view pendaftaran_pdf yang sudah didesain sesuai docx
        $pdf = Pdf::loadView('user.pendaftaran_pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Pernyataan_' . $biodata->nama_lengkap . '.pdf');
    }

    public function lihatJadwal()
    {
        $jadwal = Auth::user()->jadwalTes;
        return view('user.jadwal', compact('jadwal'));
    }

    // ==========================================
    // KODE BARU: FITUR KELULUSAN USER
    // ==========================================

    public function kelulusan()
    {
        // Cek status buka/tutup pengumuman dari pengaturan admin
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_kelulusan')->first();
        $statusKelulusan = $pengaturan ? $pengaturan->nilai : 'tutup';
        
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('user.biodata')->first();

        // Kirim $statusKelulusan ke view untuk mengontrol tampilan user
        return view('user.kelulusan', compact('statusKelulusan', 'pendaftaran'));
    }

    public function cetakSuratLulus()
    {
        // Pastikan kembali pengumuman sedang dibuka
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_kelulusan')->first();
        if (!$pengaturan || $pengaturan->nilai == 'tutup') {
            abort(403, 'Pengumuman kelulusan belum dibuka.');
        }

        $user = Auth::user();
        $pendaftaran = $user->pendaftaran;
        $biodata = $user->biodata;

        if (!$pendaftaran || $pendaftaran->status_lulus != 'lulus') {
            abort(403, 'Anda belum dinyatakan lulus atau berkas tidak ditemukan.');
        }

        $pdf = Pdf::loadView('pdf.surat_lulus', compact('biodata', 'pendaftaran'));
        return $pdf->download('Surat_Kelulusan_'.$biodata->nama_lengkap.'.pdf');
    }

    public function editPendaftaran($id)
    {
        $pendaftaran = Pendaftaran::with('user.biodata')
                        ->where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        return view('user.pendaftaran_edit', compact('pendaftaran'));
    }

    public function updatePendaftaran(Request $request, $id)
    {
        $user_id = Auth::id();
        $pendaftaran = Pendaftaran::where('id', $id)->where('user_id', $user_id)->firstOrFail();
    
        // 1. Tambahkan validasi kriteria agar wajib diisi saat update berkas
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kriteria'     => 'required|string',
            'jenis_kelamin'=> 'required',
        ]);
    
        Biodatamodel::updateOrCreate(
            ['user_id' => $user_id],
            $request->only([
                'nama_lengkap', 'jenis_kelamin', 'nisn', 'nik', 'asal_sekolah', 
                'tempat_lahir', 'tanggal_lahir', 'alamat', 'tinggal_bersama', 
                'moda_transportasi', 'anak_ke', 'tinggi_badan', 'berat_badan', 
                'jumlah_saudara', 'nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 
                'penghasilan_ayah', 'no_hp_ayah', 'nama_ibu', 'pendidikan_ibu', 
                'pekerjaan_ibu', 'penghasilan_ibu', 'no_hp_ibu'
            ])
        );
    
        $path = 'berkas_pendaftar/' . $user_id;
        
        // 2. Pastikan kriteria terikat dengan name="kriteria" dari file form edit
        $dataUpdate = [
            'kriteria'          => $request->kriteria,
            'status_verifikasi' => 'belum_diperiksa',
            'setuju_biaya'      => $request->setuju_biaya ?? $pendaftaran->setuju_biaya,
            'setuju_peraturan'  => $request->setuju_peraturan ?? $pendaftaran->setuju_peraturan,
        ];
    
        $files = [
            'file_raport', 'file_skl', 'file_akte', 'file_kk', 'file_ijazah', 
            'pas_foto', 'ktp_ortu', 'file_keterangan_sehat', 
            'file_keterangan_yatim', 'file_piagam', 'bukti_pembayaran'
        ];
    
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                if ($pendaftaran->$file && Storage::disk('public')->exists($pendaftaran->$file)) {
                    Storage::disk('public')->delete($pendaftaran->$file);
                }
                $dataUpdate[$file] = $request->file($file)->store($path, 'public');
            }
        }
    
        $ttdPath = 'signatures/' . $user_id;

        // Update Tanda Tangan Orang Tua ke kolom 'ttd_ayah'
        if ($request->filled('ttd_orang_tua')) {
            if ($pendaftaran->ttd_ayah && Storage::disk('public')->exists($pendaftaran->ttd_ayah)) {
                Storage::disk('public')->delete($pendaftaran->ttd_ayah);
            }
            $data = $request->input('ttd_orang_tua');
            $image = str_replace('data:image/png;base64,', '', $data);
            $image = str_replace(' ', '+', $image);
            $imageName = 'ttd_orang_tua_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, base64_decode($image));
            $dataUpdate['ttd_ayah'] = $ttdPath . '/' . $imageName;
        }

        // Update Tanda Tangan Siswa ke kolom 'ttd_siswa'
        if ($request->filled('ttd_siswa')) {
            if ($pendaftaran->ttd_siswa && Storage::disk('public')->exists($pendaftaran->ttd_siswa)) {
                Storage::disk('public')->delete($pendaftaran->ttd_siswa);
            }
            $data = $request->input('ttd_siswa');
            $image = str_replace('data:image/png;base64,', '', $data);
            $image = str_replace(' ', '+', $image);
            $imageName = 'ttd_siswa_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, base64_decode($image));
            $dataUpdate['ttd_siswa'] = $ttdPath . '/' . $imageName;
        }
    
        $pendaftaran->update($dataUpdate);
    
        return redirect()->route('user.riwayat')->with('success', 'Data pendaftaran berhasil diperbarui!');
    }
}