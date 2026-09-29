<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- Menambahkan proteksi pada title --}}
    <title>Detail Pendaftar - {{ $pendaftaran->user?->biodata?->nama_lengkap ?? 'Data Tidak Ditemukan' }}</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; color: #333; line-height: 1.6; padding: 20px; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; margin-bottom: 20px; padding-bottom: 10px; }
        h2 { color: #2c3e50; margin: 0; }
        h3 { background: #e9ecef; padding: 10px; border-radius: 5px; font-size: 1.1rem; margin-top: 30px; color: #495057; border-left: 5px solid #007bff; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { padding: 12px; border: 1px solid #dee2e6; text-align: left; vertical-align: top; }
        th { background: #f8f9fa; width: 30%; font-weight: 600; color: #666; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; }
        .btn-back { text-decoration: none; color: #007bff; font-weight: 500; }
        .file-box { display: inline-block; padding: 8px 15px; background: #f1f3f5; border: 1px solid #ced4da; border-radius: 5px; text-decoration: none; color: #495057; font-size: 0.9rem; margin: 5px; }
        .file-box:hover { background: #e2e6ea; }
        .form-section { background: #fff3cd; padding: 20px; border-radius: 8px; border: 1px solid #ffeeba; margin-top: 40px; }
        .ttd-box { background: #fff; border: 1px solid #dee2e6; padding: 15px; border-radius: 8px; text-align: center; }
        .ttd-img { max-height: 150px; max-width: 100%; object-fit: contain; background: #fff; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Data Lengkap Calon Siswa</h2>
        <a href="{{ route('admin.pendaftaran') }}" class="btn-back">← Kembali ke Daftar</a>
    </div>

    <h3>I. Informasi Pendaftaran</h3>
    <table>
        <tr>
            <th>Kriteria Pendaftaran</th>
            <td><strong style="color: #007bff;">{{ strtoupper($pendaftaran->kriteria ?? 'Umum') }}</strong></td>
        </tr>
        <tr> 
            <th>Status Saat Ini</th>
            <td>
                @if($pendaftaran->status_verifikasi == 'berhasil')
                    <span class="badge" style="background: #d4edda; color: #155724;">Lulus Verifikasi Berkas</span>
                @elseif($pendaftaran->status_verifikasi == 'ditolak')
                    <span class="badge" style="background: #f8d7da; color: #721c24;">Ditolak</span>
                @else
                    <span class="badge" style="background: #fff3cd; color: #856404;">Belum Diperiksa</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="grid">
        <div>
            <h3>II. Biodata Pribadi</h3>
            <table>
                {{-- Menggunakan $pendaftaran->user?->biodata untuk mencegah error jika user null --}}
                <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->user?->biodata?->nama_lengkap ?? '-' }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pendaftaran->user?->biodata?->jenis_kelamin ?? '-' }}</td></tr>
                <tr><th>NISN</th><td>{{ $pendaftaran->user?->biodata?->nisn ?? '-' }}</td></tr>
                <tr><th>NIK</th><td>{{ $pendaftaran->user?->biodata?->nik ?? '-' }}</td></tr>
                <tr><th>Asal Sekolah</th><td>{{ $pendaftaran->user?->biodata?->asal_sekolah ?? '-' }}</td></tr>
                <tr><th>Tempat, Tgl Lahir</th><td>{{ $pendaftaran->user?->biodata?->tempat_lahir ?? '-' }}, {{ $pendaftaran->user?->biodata?->tanggal_lahir ?? '-' }}</td></tr>
                <tr><th>Alamat Lengkap</th><td>{{ $pendaftaran->user?->biodata?->alamat ?? '-' }}</td></tr>
                <tr><th>Tinggal Bersama</th><td>{{ $pendaftaran->user?->biodata?->tinggal_bersama ?? '-' }}</td></tr>
                <tr><th>Moda Transportasi</th><td>{{ $pendaftaran->user?->biodata?->moda_transportasi ?? '-' }}</td></tr>
            </table>

            <h3>III. Data Periodik</h3>
            <table>
                <tr><th>Anak Ke</th><td>{{ $pendaftaran->user?->biodata?->anak_ke ?? '-' }}</td></tr>
                <tr><th>Jumlah Saudara</th><td>{{ $pendaftaran->user?->biodata?->jumlah_saudara ?? '-' }}</td></tr>
                <tr><th>Tinggi Badan</th><td>{{ $pendaftaran->user?->biodata?->tinggi_badan ?? '-' }} cm</td></tr>
                <tr><th>Berat Badan</th><td>{{ $pendaftaran->user?->biodata?->berat_badan ?? '-' }} kg</td></tr>
            </table>
        </div>

        <div>
            <h3>IV. Data Orang Tua</h3>
            <table style="margin-bottom: 20px;">
                <tr><th colspan="2" style="text-align: center; background: #dee2e6;">DATA AYAH</th></tr>
                <tr><th>Nama Ayah</th><td>{{ $pendaftaran->user?->biodata?->nama_ayah ?? '-' }}</td></tr>
                <tr><th>Pekerjaan</th><td>{{ $pendaftaran->user?->biodata?->pekerjaan_ayah ?? '-' }}</td></tr>
                <tr><th>Penghasilan</th><td>{{ $pendaftaran->user?->biodata?->penghasilan_ayah ?? '-' }}</td></tr>
                <tr><th>No. HP Ayah</th><td>{{ $pendaftaran->user?->biodata?->no_hp_ayah ?? '-' }}</td></tr>
            </table>

            <table>
                <tr><th colspan="2" style="text-align: center; background: #dee2e6;">DATA IBU</th></tr>
                <tr><th>Nama Ibu</th><td>{{ $pendaftaran->user?->biodata?->nama_ibu ?? '-' }}</td></tr>
                <tr><th>Pekerjaan</th><td>{{ $pendaftaran->user?->biodata?->pekerjaan_ibu ?? '-' }}</td></tr>
                <tr><th>Penghasilan</th><td>{{ $pendaftaran->user?->biodata?->penghasilan_ibu ?? '-' }}</td></tr>
                <tr><th>No. HP Ibu</th><td>{{ $pendaftaran->user?->biodata?->no_hp_ibu ?? '-' }}</td></tr>
            </table>
        </div>
    </div>

    <h3>V. Berkas Persyaratan (Upload)</h3>
    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6;">
        @php
            $files = [
                'Bukti Pembayaran' => 'bukti_pembayaran', 'File Raport' => 'file_raport',
                'Pas Foto' => 'pas_foto', 'Akte Kelahiran' => 'file_akte',
                'Kartu Keluarga' => 'file_kk', 'SKL' => 'file_skl',
                'Ijazah' => 'file_ijazah', 'KTP Orang Tua' => 'ktp_ortu',
                'Ket. Sehat' => 'file_keterangan_sehat', 'Ket. Yatim' => 'file_keterangan_yatim',
                'Piagam' => 'file_piagam',
            ];
        @endphp
        @foreach($files as $label => $column)
            @if($pendaftaran->$column)
                <a href="{{ asset('storage/' . $pendaftaran->$column) }}" target="_blank" class="file-box">📄 {{ $label }}</a>
            @endif
        @endforeach
    </div>

    <h3>VI. Pernyataan & Tanda Tangan</h3>
    <div class="grid" style="margin-top: 10px;">
        <div class="ttd-box">
            <h4 style="font-size: 0.9rem; margin-bottom: 10px; color: #555;">PERNYATAAN ORANG TUA</h4>
            @if($pendaftaran->ttd_ayah || $pendaftaran->ttd_orang_tua)
                <img src="{{ asset('storage/' . ($pendaftaran->ttd_ayah ?? $pendaftaran->ttd_orang_tua)) }}" class="ttd-img" alt="TTD Orang Tua">
            @else
                <p style="color: #dc3545; font-size: 0.8rem; padding: 20px;">Tanda tangan belum tersedia</p>
            @endif
        </div>
        <div class="ttd-box">
            <h4 style="font-size: 0.9rem; margin-bottom: 10px; color: #555;">PERNYATAAN SISWA</h4>
            @if($pendaftaran->ttd_siswa)
                <img src="{{ asset('storage/' . $pendaftaran->ttd_siswa) }}" class="ttd-img" alt="TTD Siswa">
            @else
                <p style="color: #dc3545; font-size: 0.8rem; padding: 20px;">Tanda tangan belum tersedia</p>
            @endif
        </div>
    </div>

    <div class="form-section">
        <h3>VII. Keputusan & Catatan Admin</h3>
        <form action="{{ route('admin.verifikasi', $pendaftaran->id) }}" method="POST">
            @csrf
            <select name="status" style="width: 100%; padding: 12px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="belum_diperiksa" {{ $pendaftaran->status_verifikasi == 'belum_diperiksa' ? 'selected' : '' }}>Belum Diperiksa</option>
                <option value="berhasil" {{ $pendaftaran->status_verifikasi == 'berhasil' ? 'selected' : '' }}>Lulus</option>
                <option value="ditolak" {{ $pendaftaran->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Tidak Lulus</option>
            </select>
            <textarea name="catatan_verifikasi" rows="5" style="width: 100%; padding: 12px; margin-top: 10px; border-radius: 5px; border: 1px solid #ccc;">{{ $pendaftaran->catatan_verifikasi }}</textarea>
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 15px; margin-top: 10px; border-radius: 5px; width: 100%;">SIMPAN KEPUTUSAN</button>
        </form>
    </div>
</div>

</body>
</html>