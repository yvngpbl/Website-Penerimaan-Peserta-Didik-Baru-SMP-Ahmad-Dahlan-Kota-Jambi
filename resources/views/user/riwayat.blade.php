
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Lengkap - SMP IT Ahmad Dahlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #198754; }
        .logo-img {
            width: 45px; 
            height: 45px; 
            border-radius: 50%; 
            object-fit: cover; 
            background-color: white; 
            border: 2px solid white; 
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .section-title { background: #198754; color: white; padding: 8px 15px; font-weight: bold; margin-top: 25px; border-radius: 5px; }
        .table-detail th { background-color: #f1f1f1; width: 30%; }
        .card { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .ttd-img { max-height: 120px; max-width: 100%; object-fit: contain; }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            /* Penyesuaian Navbar */
            .container-fluid { flex-direction: column; gap: 12px; align-items: center; }
            .navbar-brand { justify-content: center; width: 100%; }
            .navbar-brand span { font-size: 18px !important; text-align: center; }
            nav .btn-outline-light { width: 100%; }

            /* Jarak Container dan Card Utama */
            .container { padding-left: 15px; padding-right: 15px; }
            .card { padding: 20px !important; }

            /* Header Section (Judul & Tombol Edit) */
            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                align-items: stretch !important;
            }
            .d-flex.justify-content-between.align-items-center.mb-4 a,
            .d-flex.justify-content-between.align-items-center.mb-4 button {
                width: 100%;
            }

            /* Responsive Table Magic (Ubah tabel jadi bentuk list vertikal) */
            .table-detail, .table-detail tbody, .table-detail tr, .table-detail th, .table-detail td {
                display: block;
                width: 100%;
            }
            .table-detail tr {
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
            }
            .table-detail th {
                background-color: #e8f5e9 !important; /* Warna hijau sangat muda untuk pemisah */
                border-bottom: 1px solid #dee2e6;
                padding: 10px 15px;
            }
            .table-detail td {
                border-bottom: none;
                padding: 10px 15px;
            }
            
            /* Penyesuaian khusus Header Tabel Pemisah "Data Ayah / Ibu" */
            .table-detail tr.table-light th {
                background-color: #198754 !important;
                color: white;
                text-align: center;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark p-3">
    <div class="container-fluid">
        
        <div class="navbar-brand m-0">
            <img src="{{ asset('storage/images/logo2.png') }}" alt="Logo SMP IT Ahmad Dahlan" class="logo-img">
            <span class="mb-0 fs-5 fw-bold text-uppercase">SMP IT Ahmad Dahlan</span>
        </div>

        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
        
    </div>
</nav>

<div class="container my-5">
    <div class="card p-4">
        @if(!$pendaftaran)
            <div class="alert alert-danger text-center">Data pendaftaran tidak ditemukan.</div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-0">Detail Data Pendaftaran</h2>
                    <p class="text-muted">Berikut adalah data lengkap yang telah Anda unggah</p>
                </div>
                
                @if($pendaftaran->status_verifikasi != 'berhasil')
                    <a href="{{ route('user.pendaftaran.edit', $pendaftaran->id) }}" class="btn btn-warning btn-lg fw-bold shadow-sm">
                        EDIT DATA & BERKAS
                    </a>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>✅ Data Sudah Diverifikasi</button>
                @endif
            </div>

            <div class="alert {{ $pendaftaran->status_verifikasi == 'ditolak' ? 'alert-danger' : 'alert-info' }} border-0 shadow-sm">
                <strong>Status Verifikasi:</strong> 
                <span class="badge bg-{{ $pendaftaran->status_verifikasi == 'berhasil' ? 'success' : ($pendaftaran->status_verifikasi == 'ditolak' ? 'danger' : 'warning text-dark') }}">
                    {{ strtoupper(str_replace('_', ' ', $pendaftaran->status_verifikasi)) }}
                </span>
                <div class="mt-2 p-2 bg-white rounded border border-light">
                    <strong>Catatan Admin:</strong> {{ $pendaftaran->catatan_verifikasi ?? 'Belum ada catatan.' }}
                </div>
            </div>

            <div class="section-title">A. IDENTITAS CALON SISWA</div>
            <table class="table table-bordered table-detail mt-2">
                <tr><th>Nama Lengkap</th><td>{{ $pendaftaran->user->biodata->nama_lengkap }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pendaftaran->user->biodata->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                <tr><th>NISN</th><td>{{ $pendaftaran->user->biodata->nisn }}</td></tr>
                <tr><th>NIK</th><td>{{ $pendaftaran->user->biodata->nik }}</td></tr>
                <tr><th>Asal Sekolah</th><td>{{ $pendaftaran->user->biodata->asal_sekolah }}</td></tr>
                <tr><th>Tempat, Tanggal Lahir</th><td>{{ $pendaftaran->user->biodata->tempat_lahir }}, {{ $pendaftaran->user->biodata->tanggal_lahir }}</td></tr>
                <tr><th>Alamat Lengkap</th><td>{{ $pendaftaran->user->biodata->alamat }}</td></tr>
                <tr><th>Tinggal Bersama</th><td>{{ $pendaftaran->user->biodata->tinggal_bersama }}</td></tr>
                <tr><th>Moda Transportasi</th><td>{{ $pendaftaran->user->biodata->moda_transportasi }}</td></tr>
                <tr><th>Anak Ke</th><td>{{ $pendaftaran->user->biodata->anak_ke }} dari {{ $pendaftaran->user->biodata->jumlah_saudara }} bersaudara</td></tr>
                <tr><th>Tinggi / Berat Badan</th><td>{{ $pendaftaran->user->biodata->tinggi_badan }} cm / {{ $pendaftaran->user->biodata->berat_badan }} kg</td></tr>
                <tr>
                    <th>Kriteria Pendaftaran</th>
                    <td>
                        @php
                            // Ubah teks dari database ke huruf kecil semua agar kebal dari salah format huruf besar/kecil
                            $kriteria_db = strtolower(trim($pendaftaran->kriteria));
                            
                            $daftar_kriteria = [
                                'umum'              => 'Umum',
                                'anak_guru'         => 'Anak Guru (SD IT AD, SMP AD)',
                                'anak guru'         => 'Anak Guru (SD IT AD, SMP AD)',
                                'alumni'            => 'Alumni SD IT Ahmad Dahlan',
                                'saudara'           => 'Punya Saudara Kandung di SD IT / SMP AD',
                                'saudara kandung'   => 'Punya Saudara Kandung di SD IT / SMP AD',
                                'prestasi'          => 'Siswa Prestasi',
                                'siswa prestasi'    => 'Siswa Prestasi',
                                'yatim'             => 'Siswa Yatim',
                                'siswa yatim'       => 'Siswa Yatim',
                            ];
                            
                            $terpilih = $daftar_kriteria[$kriteria_db] ?? $pendaftaran->kriteria;
                        @endphp
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2">●</span> 
                            <strong class="text-uppercase">{{ $terpilih }}</strong>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="section-title">B. DATA ORANG TUA</div>
            <table class="table table-bordered table-detail mt-2">
                <tr class="table-light"><th colspan="2">Data Ayah</th></tr>
                <tr><th>Nama Ayah</th><td>{{ $pendaftaran->user->biodata->nama_ayah }}</td></tr>
                <tr><th>Pekerjaan / Pendidikan</th><td>{{ $pendaftaran->user->biodata->pekerjaan_ayah }} / {{ $pendaftaran->user->biodata->pendidikan_ayah }}</td></tr>
                <tr><th>Penghasilan / HP</th><td>Rp. {{ number_format((float)$pendaftaran->user->biodata->penghasilan_ayah, 0, ',', '.') }} / {{ $pendaftaran->user->biodata->no_hp_ayah }}</td></tr>
                
                <tr class="table-light"><th colspan="2">Data Ibu</th></tr>
                <tr><th>Nama Ibu</th><td>{{ $pendaftaran->user->biodata->nama_ibu }}</td></tr>
                <tr><th>Pekerjaan / Pendidikan</th><td>{{ $pendaftaran->user->biodata->pekerjaan_ibu }} / {{ $pendaftaran->user->biodata->pendidikan_ibu }}</td></tr>
                <th>Penghasilan / HP</th>
                <td>
                    Rp. {{ number_format((float)($pendaftaran->user->biodata->penghasilan_ibu ?? 0), 0, ',', '.') }} / {{ $pendaftaran->user->biodata->no_hp_ibu }}
                </td>
            </table>

            <div class="section-title">C. BERKAS PENDAFTARAN</div>
            <div class="row mt-3 text-center">
                @php
                    // Berkas wajib untuk semua jalur
                    $berkasList = [
                        'file_raport' => 'Raport', 'file_skl' => 'SKL', 'file_akte' => 'Akte',
                        'file_kk' => 'KK', 'file_ijazah' => 'Ijazah', 'pas_foto' => 'Foto',
                        'ktp_ortu' => 'KTP Ortu', 'file_keterangan_sehat' => 'Ket. Sehat',
                        'bukti_pembayaran' => 'Bukti Bayar'
                    ];

                    // Pengecekan Fleksibel: Jika di database mengandung kata "prestasi", munculkan
                    if (str_contains($kriteria_db, 'prestasi')) {
                        $berkasList['file_piagam'] = 'Piagam';
                    }
                    
                    // Pengecekan Fleksibel: Jika di database mengandung kata "yatim", munculkan
                    if (str_contains($kriteria_db, 'yatim')) {
                        $berkasList['file_keterangan_yatim'] = 'Ket. Yatim';
                    }
                @endphp

                @foreach($berkasList as $key => $label)
                <div class="col-md-3 mb-3">
                    <div class="card p-2 border shadow-sm h-100">
                        <small class="text-muted fw-bold">{{ $label }}</small>
                        <div class="mt-2">
                            @if($pendaftaran->$key)
                                <a href="{{ asset('storage/'.$pendaftaran->$key) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Berkas</a>
                            @else
                                <span class="badge bg-light text-danger">Tidak Ada</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="section-title">D. PERSETUJUAN & TANDA TANGAN</div>
            <div class="row mt-3">
                <div class="col-md-6 mb-3">
                    <div class="card p-3 border shadow-sm h-100">
                        <h6 class="fw-bold border-bottom pb-2">Pernyataan Orang Tua/Wali</h6>
                        <div class="mb-3">
                            <small class="text-muted d-block">Status Persetujuan Biaya:</small>
                            {{-- PENYESUAIAN NAMA KOLOM MYSQL --}}
                            @if($pendaftaran->setuju_biaya_masuk)
                                <span class="badge bg-success">SUDAH SETUJU</span>
                            @else
                                <span class="badge bg-danger">BELUM SETUJU</span>
                            @endif
                        </div>
                        <div class="text-center bg-light p-2 rounded border">
                        <small class="text-muted d-block mb-2">Tanda Tangan Digital:</small>
                            @if($pendaftaran->ttd_ayah)
                                <img src="{{ asset('storage/'.$pendaftaran->ttd_ayah) }}" class="ttd-img" alt="TTD Ortu">
                            @else
                                <div class="py-4 text-danger small">Belum ada tanda tangan</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card p-3 border shadow-sm h-100">
                        <h6 class="fw-bold border-bottom pb-2">Pernyataan Calon Siswa</h6>
                        <div class="mb-3">
                            <small class="text-muted d-block">Status Persetujuan Peraturan:</small>
                            {{-- PENYESUAIAN NAMA KOLOM MYSQL --}}
                            @if($pendaftaran->setuju_peraturan_sekolah)
                                <span class="badge bg-success">SUDAH SETUJU</span>
                            @else
                                <span class="badge bg-danger">BELUM SETUJU</span>
                            @endif
                        </div>
                        <div class="text-center bg-light p-2 rounded border">
                            <small class="text-muted d-block mb-2">Tanda Tangan Digital:</small>
                            @if($pendaftaran->ttd_siswa)
                                <img src="{{ asset('storage/'.$pendaftaran->ttd_siswa) }}" class="ttd-img" alt="TTD Siswa">
                            @else
                                <div class="py-4 text-danger small">Belum ada tanda tangan</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($pendaftaran->tgl_persetujuan)
                <div class="mt-2 text-end">
                    <p class="text-muted" style="font-size: 0.85rem;">
                        Disetujui pada: {{ \Carbon\Carbon::parse($pendaftaran->tgl_persetujuan)->format('d/m/Y H:i') }} WIB
                    </p>
                </div>
            @endif

        @endif
    </div>
</div>

</body>
</html>