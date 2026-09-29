
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Kelulusan - SPMB SMP IT Ahmad Dahlan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content { flex: 1; }

        /* Navbar & Footer Styling (Sesuai Dashboard Anda) */
        .custom-navbar { background-color: #198754; color: white; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .custom-navbar h2 { margin: 0; font-size: 22px; font-weight: bold !important; }
        .custom-navbar-brand { display: flex; align-items: center; gap: 15px; }
        .custom-navbar-links a { color: white !important; text-decoration: none; margin-left: 20px; font-weight: bold !important; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; font-size: 16px; }
        .custom-navbar-links a:hover { background-color: rgba(255, 255, 255, 0.1) !important; }
        .custom-navbar-links a.active { background-color: white !important; color: #198754 !important; }
        .logo-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; background-color: white; border: 2px solid white; }

        .custom-footer { background-color: #333; color: white; text-align: center; display: flex; justify-content: space-between; align-items: center; padding: 20px; font-size: 16px; }
        .btn-logout { background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-size: 16px; margin-left: 20px; padding: 8px 15px; }
        .btn-logout:hover { background-color: rgba(220, 53, 69, 0.8); }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            /* Navbar Penyesuaian */
            .custom-navbar {
                padding: 15px;
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            .custom-navbar-brand {
                justify-content: center;
                width: 100%;
            }
            .custom-navbar-brand h2 {
                font-size: 20px !important;
                text-align: center;
            }
            .custom-navbar-links {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
            .custom-navbar-links a {
                margin-left: 0 !important;
                padding: 10px;
                font-size: 15px;
                display: block;
                text-align: center;
                width: 100%;
                box-sizing: border-box;
            }
            
            /* Menyesuaikan form dan tombol logout di mobile */
            form[action*="logout"] { width: 100%; }
            .btn-logout {
                margin-left: 0;
                width: 100%;
                display: block;
                padding: 12px;
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Container Penyesuaian */
            .container { padding-left: 15px; padding-right: 15px; }
            h3.fw-bold { font-size: 22px; }

            /* Footer Penyesuaian */
            .custom-footer {
                flex-direction: column;
                justify-content: center;
                text-align: center;
                padding: 15px;
                gap: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="custom-navbar">
        <div class="custom-navbar-brand">
            <img src="{{ asset('storage/images/logo2.png') }}" alt="Logo" class="logo-img">
            <h2>SMP IT AHMAD DAHLAN</h2>
        </div>
        <div class="custom-navbar-links">
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            <a href="{{ route('user.pendaftaran') }}">Daftar</a>
            <a href="{{ route('user.riwayat') }}">Riwayat</a>
            <a href="{{ route('user.kelulusan') }}" class="active">Pengumuman Kelulusan</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container py-5 main-content">
        <div class="text-center mb-5">
            <h3 class="fw-bold text-success">Pengumuman Hasil Seleksi Kelulusan Calon Siswa Baru (SPMB)</h3>
        </div>

        @if($statusKelulusan == 'buka')
            @if(isset($pendaftaran) && $pendaftaran->status_lulus == 'lulus')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">SELAMAT, ANDA DINYATAKAN LULUS (DITERIMA)!</h4>
                    </div>
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">DATA LENGKAP CALON SISWA</h6>
                        <div class="row mb-2"><div class="col-md-3 text-muted">Nama Lengkap</div><div class="col-md-9 fw-bold">: {{ $pendaftaran->user->biodata->nama_lengkap ?? '-' }}</div></div>
                        <div class="row mb-2"><div class="col-md-3 text-muted">NISN</div><div class="col-md-9 fw-bold">: {{ $pendaftaran->user->biodata->nisn ?? '-' }}</div></div>
                        <div class="row mb-4"><div class="col-md-3 text-muted">Asal Sekolah</div><div class="col-md-9 fw-bold">: {{ $pendaftaran->user->biodata->asal_sekolah ?? '-' }}</div></div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100">
                                    <div class="card-body text-center d-flex flex-column justify-content-center">
                                        <h6 class="fw-bold">HASIL SELEKSI</h6>
                                        <div class="d-flex align-items-center justify-content-center my-3 text-success">
                                            <i class="fas fa-check-circle fa-3x"></i>
                                        </div>
                                        <a href="{{ route('user.cetak_lulus') }}" class="btn btn-success w-100 fw-bold">
                                            <i class="fas fa-download me-2"></i>UNDUH SURAT KELULUSAN RESMI (PDF)
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100 bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold">LANGKAH SELANJUTNYA:</h6>
                                        <p class="mb-2 text-muted">Pantau Instagram SMP AHMAD DAHLAN Mengenai Informasi Lanjutan Untuk Daftar Ulang.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(isset($pendaftaran) && $pendaftaran->status_lulus == 'tidak_lulus')
                <div class="card border-0 shadow-sm text-center p-5">
                    <i class="fas fa-times-circle text-danger fa-4x mb-3"></i>
                    <h4 class="fw-bold">Mohon Maaf, Anda Dinyatakan Tidak Lulus</h4>
                    <p class="text-muted">Terima kasih telah berpartisipasi dalam proses seleksi SMP IT Ahmad Dahlan.</p>
                </div>
            @else
                <div class="card border-0 shadow-sm text-center p-5">
                    <i class="fas fa-clock text-warning fa-4x mb-3"></i>
                    <h4 class="fw-bold">Status Sedang Diproses</h4>
                    <p class="text-muted">Hasil seleksi Anda sedang dalam tahap verifikasi akhir oleh Admin.</p>
                </div>
            @endif
        @else
            <div class="card border-0 shadow-sm p-5 text-center">
                <i class="fas fa-lock text-muted fa-4x mb-3"></i>
                <h4 class="fw-bold">Pengumuman Belum Dibuka</h4>
                <p class="text-muted">Hasil seleksi kelulusan belum dipublikasikan oleh panitia. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>

    <div class="custom-footer">
        <div class="px-4">2026 Sistem Informasi SPMB - SMP IT Ahmad Dahlan Kota Jambi.</div>
    </div>
</body>
</html>