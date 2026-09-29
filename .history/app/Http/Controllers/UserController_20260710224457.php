<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biodatamodel;
use App\Models\Pendaftaran;
use App\Models\JadwalTes;
use App\Models\Pengaturan;
use App\Models\Notifikasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $biodata = $user->biodata;
        $pendaftaran = $user->pendaftaran;
        
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_kelulusan')->first();
        $statusKelulusan = $pengaturan ? $pengaturan->nilai : 'tutup';
        
        $notifikasi = Notifikasi::where('user_id', $user->id)->first();
        
        return view('user.DashboardUser', compact('biodata', 'pendaftaran', 'statusKelulusan', 'notifikasi'));
    }

    public function pendaftaran()
    {
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_pendaftaran')->first();
        $status = $pengaturan ? $pengaturan->nilai : 'tutup';
        $user = Auth::user();

        return view('user.pendaftaran', compact('status', 'user'));
    }

    public function storePendaftaran(Request $request)
    {
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_pendaftaran')->first();
        $status = $pengaturan ? $pengaturan->nilai : 'tutup';
        
        if ($status === 'tutup') {
            return redirect()->route('user.pendaftaran')->with('error', 'Mohon maaf, pendaftaran saat ini telah ditutup oleh panitia.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'nisn' => 'nullable|string',
            'nik' => 'nullable|string',
            'asal_sekolah' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kriteria' => 'required',
            'bukti_pembayaran' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            
            'file_piagam' => 'required_if:kriteria,Siswa Prestasi|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_keterangan_yatim' => 'required_if:kriteria,Siswa Yatim|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'file_piagam.required_if' => 'Karena Anda memilih jalur Prestasi, mohon unggah Scan Piagam/Sertifikat pada poin 9.',
            'file_keterangan_yatim.required_if' => 'Karena Anda memilih jalur Siswa Yatim, mohon unggah Scan Surat Keterangan Yatim pada poin 10.'
        ]);

        $user_id = Auth::id();

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
        $dataPendaftaran = [
            'user_id' => $user_id,
            'kriteria' => $request->kriteria,
            'status_verifikasi' => 'belum_diperiksa',
        ];

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

        Pendaftaran::updateOrCreate(['user_id' => $user_id], $dataPendaftaran);

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
            'ttl_manual' => 'required|string',
            'alamat_manual' => 'required|string',
            'no_hp_ortu' => 'required|string',
        ]);

        $user_id = Auth::id();
        $pendaftaran = Pendaftaran::where('user_id', $user_id)->firstOrFail();

        // PENYIMPANAN MUTLAK: Menggunakan Assignment Langsung (Bypass Mass Assignment Laravel)
        // Karena form tidak bisa disubmit sebelum user mencentangnya (berkat validasi JS), kita tetapkan nilainya 1.
        $pendaftaran->setuju_biaya = 1;
        $pendaftaran->setuju_peraturan = 1;
        $pendaftaran->tgl_persetujuan = now();
        $pendaftaran->ttl_siswa = $request->ttl_manual; 
        $pendaftaran->alamat_lengkap = $request->alamat_manual;
        $pendaftaran->no_hp_ortu = $request->no_hp_ortu;

        $ttdPath = 'signatures/' . $user_id;
        if (!Storage::disk('public')->exists($ttdPath)) {
            Storage::disk('public')->makeDirectory($ttdPath, 0755, true);
        }

        if ($request->filled('ttd_orang_tua')) {
            $data = $request->input('ttd_orang_tua');
            $image_parts = explode(";base64,", $data);
            $image_base64 = base64_decode($image_parts[1]);
            
            $imageName = 'ttd_orang_tua_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, $image_base64);
            $pendaftaran->ttd_ayah = $ttdPath . '/' . $imageName; // Mutlak Assign
        }

        if ($request->filled('ttd_siswa')) {
            $data = $request->input('ttd_siswa');
            $image_parts = explode(";base64,", $data);
            $image_base64 = base64_decode($image_parts[1]);
            
            $imageName = 'ttd_siswa_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, $image_base64);
            $pendaftaran->ttd_siswa = $ttdPath . '/' . $imageName; // Mutlak Assign
        }

        // Simpan langsung dan paksa tulis ke database
        $pendaftaran->save();

        return redirect()->route('user.riwayat')->with('success', 'Formulir pernyataan berhasil disimpan!');
    }

    public function riwayat()
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->with('user.biodata')->first();
        if (!$pendaftaran) {
            return redirect()->route('user.pendaftaran')->with('info', 'Anda belum melakukan pendaftaran.');
        }
        return view('user.riwayat', compact('pendaftaran'));
    }

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

        $pdf = Pdf::loadView('user.pendaftaran_pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Pernyataan_' . $biodata->nama_lengkap . '.pdf');
    }

    public function lihatJadwal()
    {
        $jadwal = Auth::user()->jadwalTes;
        return view('user.jadwal', compact('jadwal'));
    }

    public function kelulusan()
    {
        $pengaturan = (new Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_kelulusan')->first();
        $statusKelulusan = $pengaturan ? $pengaturan->nilai : 'tutup';
        
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->with('user.biodata')->first();

        return view('user.kelulusan', compact('statusKelulusan', 'pendaftaran'));
    }

    public function cetakSuratLulus()
    {
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
        
        // PENYIMPANAN MUTLAK FITUR UPDATE: Bypass Mass Assignment
        $pendaftaran->kriteria = $request->kriteria;
        $pendaftaran->status_verifikasi = 'belum_diperiksa';
        
        // Status centang kita deteksi kembali
        $pendaftaran->setuju_biaya = $request->has('setuju_biaya') ? 1 : 0;
        $pendaftaran->setuju_peraturan = $request->has('setuju_peraturan') ? 1 : 0;
    
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
                $pendaftaran->$file = $request->file($file)->store($path, 'public');
            }
        }
    
        $ttdPath = 'signatures/' . $user_id;

        if ($request->filled('ttd_orang_tua')) {
            if ($pendaftaran->ttd_ayah && Storage::disk('public')->exists($pendaftaran->ttd_ayah)) {
                Storage::disk('public')->delete($pendaftaran->ttd_ayah);
            }
            
            $data = $request->input('ttd_orang_tua');
            $image_parts = explode(";base64,", $data);
            $image_base64 = base64_decode($image_parts[1]);
            
            $imageName = 'ttd_orang_tua_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, $image_base64);
            $pendaftaran->ttd_ayah = $ttdPath . '/' . $imageName;
        }

        if ($request->filled('ttd_siswa')) {
            if ($pendaftaran->ttd_siswa && Storage::disk('public')->exists($pendaftaran->ttd_siswa)) {
                Storage::disk('public')->delete($pendaftaran->ttd_siswa);
            }
            
            $data = $request->input('ttd_siswa');
            $image_parts = explode(";base64,", $data);
            $image_base64 = base64_decode($image_parts[1]);
            
            $imageName = 'ttd_siswa_' . time() . '.png';
            Storage::disk('public')->put($ttdPath . '/' . $imageName, $image_base64);
            $pendaftaran->ttd_siswa = $ttdPath . '/' . $imageName;
        }
    
        // Simpan langsung dan paksa tulis ke database
        $pendaftaran->save();
    
        return redirect()->route('user.riwayat')->with('success', 'Data pendaftaran berhasil diperbarui!');
    }
}