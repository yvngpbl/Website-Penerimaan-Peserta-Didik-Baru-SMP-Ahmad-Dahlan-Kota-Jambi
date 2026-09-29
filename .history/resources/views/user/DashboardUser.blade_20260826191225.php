
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Siswa - SPMB SMP IT Ahmad Dahlan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        /* Navbar Styling */
        .navbar {
            background-color: #871981; /* Hijau */
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar h2 {
            margin: 0;
            font-size: 22px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .navbar-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar-links a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .navbar-links a.active {
            background-color: white;
            color: #198754;
        }

        .logo-img {
            width: 45px; 
            height: 45px; 
            border-radius: 50%; 
            object-fit: cover; 
            background-color: white; 
            border: 2px solid white; 
        }

        /* --- TAMBAHAN CSS DROPDOWN INFORMASI (LANGKAH 2) --- */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            z-index: 1000;
            border-radius: 5px;
            margin-top: 10px;
            overflow: hidden;
        }
        .dropdown-content a {
            color: #333 !important;
            padding: 12px 16px !important;
            text-decoration: none;
            display: block;
            margin: 0 !important; 
            font-weight: bold;
            font-size: 14px !important;
            border-bottom: 1px solid #eee;
            border-radius: 0 !important; 
            transition: background 0.3s;
        }
        .dropdown-content a:hover {
            background-color: #e8f5e9 !important;
            color: #198754 !important;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        /* --------------------------------------------------- */

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 100px 20px; 
            background-image: linear-gradient(rgba(232, 245, 233, 0.85), rgba(232, 245, 233, 0.85)), url('{{ asset("storage/images/fotosekolah1.jpg") }}');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            border-bottom: 2px solid #c8e6c9;
        }
        .hero h1 {
            font-size: 36px;
            color: #198754;
            margin-bottom: 10px;
        }
        .hero p {
            font-size: 18px;
            color: #555;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        
        /* Info Alur Pendaftaran */
        .info-section {
            padding: 50px 20px;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }
        .info-section h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 40px;
        }
        .grid-alur {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .card-alur {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            border-top: 4px solid #198754;
        }
        .card-alur h4 {
            color: #198754;
            margin-bottom: 10px;
        }
        
        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-top: 40px;
        }
        .footer-left, .footer-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Style tambahan untuk tombol logout agar selaras */
        .btn-logout {
            background: none;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-family: inherit;
            font-size: 16px;
            margin-left: 20px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background-color: rgba(220, 53, 69, 0.8); 
        }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            .navbar {
                padding: 15px;
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            .navbar-brand {
                justify-content: center;
                width: 100%;
            }
            .navbar-brand h2 {
                font-size: 20px;
                text-align: center;
            }
            .navbar-links {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
            .navbar-links a {
                margin-left: 0;
                padding: 10px;
                font-size: 15px;
                display: block;
                text-align: center;
                width: 100%;
                box-sizing: border-box;
            }
            
            /* Penyesuaian Dropdown di Mobile agar tidak terpotong */
            .dropdown {
                width: 100%;
            }
            .dropdown-content {
                position: static; /* Mengubah absolute menjadi static agar mendesak elemen di bawahnya */
                width: 100%;
                box-shadow: none;
                background-color: rgba(255, 255, 255, 0.95);
                margin-top: 5px;
            }
            .dropdown-content a {
                text-align: center;
            }
            
            /* Penyesuaian form dan tombol logout di mobile */
            form[action*="logout"] {
                width: 100%;
            }
            .btn-logout {
                margin-left: 0;
                width: 100%;
                display: block;
                padding: 12px;
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Penyesuaian Hero Section */
            .hero {
                padding: 60px 15px;
            }
            .hero h1 {
                font-size: 24px;
            }
            .hero p {
                font-size: 15px;
                margin: 0 auto 20px;
            }
            
            /* Box Welcome Message Responsif */
            .hero > div {
                padding: 12px 20px !important;
                font-size: 14px;
            }

            .info-section {
                padding: 30px 15px;
            }
            .info-section h3 {
                font-size: 22px;
                margin-bottom: 20px;
            }

            /* Penyesuaian Footer agar susunannya rapi ke bawah dan ke tengah */
            .footer {
                flex-direction: column;
                gap: 15px;
                padding: 20px 15px;
            }
            .footer-left, .footer-right {
                justify-content: center;
                width: 100%;
            }
            .footer-center {
                font-size: 14px;
                text-align: center;
                line-height: 1.5;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="navbar-brand">
            <img src="{{ asset('storage/images/logo2.png') }}" alt="Logo SMP IT Ahmad Dahlan" class="logo-img">
            
            <h2>SMP IT AHMAD DAHLAN</h2>
        </div>
        <div class="navbar-links">
            <a href="{{ route('user.dashboard') }}" class="active">Beranda</a>
            
            <div class="dropdown">
                <a href="#" style="cursor: pointer;">Informasi <span class="dropdown-icon">&#x25BC;</span></a>
                <div class="dropdown-content">
                    <a href="{{ route('info.sekilas') }}">Sekilas SMP IT</a>
                    <a href="{{ route('info.visimisi') }}">Visi & Misi</a>
                    <a href="{{ route('info.fasilitas') }}">Fasilitas</a>
                    <a href="{{ route('info.ekskul') }}">Ekstrakurikuler</a>
                    <a href="{{ route('info.prestasi') }}">Prestasi</a>
                </div>
            </div>
            <a href="{{ route('user.pendaftaran') }}">Daftar</a>
            <a href="{{ route('user.riwayat') }}">Riwayat</a>
            <a href="{{ route('user.kelulusan') }}">Pengumuman Kelulusan</a>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="hero">
        <h1>Penerimaan Peserta Didik Baru (SPMB)</h1>
        <p>Selamat datang di portal resmi pendaftaran siswa baru SMP IT Ahmad Dahlan Kota Jambi Tahun Ajaran 2026/2027. Mari bergabung dan mencetak generasi Islami yang cerdas dan berprestasi.</p>
        
        <div style="background-color: white; padding: 15px 30px; border-radius: 50px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #198754;">
            <p style="color: #198754; font-weight: bold; margin: 0;">Selamat Datang, Calon Siswa (NISN: {{ Auth::user()->nisn }})!</p>
        </div>
    </div>

    <div class="info-section">
        <h3>Alur Pendaftaran SPMB</h3>
        <div class="grid-alur">
            <div class="card-alur">
                <h4>1. Registrasi Akun</h4>
                <p>Buat akun menggunakan NISN dan Password di website ini.</p>
            </div>
            <div class="card-alur">
                <h4>2. Upload Berkas</h4>
                <p>Lengkapi formulir biodata dan unggah berkas persyaratan (PDF/Foto).</p>
            </div>
            <div class="card-alur">
                <h4>3. Verifikasi & Tes</h4>
                <p>Tunggu verifikasi admin. Jika berhasil, ikuti tes ngaji & wawancara di sekolah.</p>
            </div>
            <div class="card-alur">
                <h4>4. Pengumuman</h4>
                <p>Cek status kelulusan di dashboard dan cetak surat lulus otomatis.</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-left">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Senin - sabtu, 08.00 - 17.00 WIB</span>
        </div>
        <div class="footer-center">
            <span>2026 Sistem Informasi SPMB - SMP IT Ahmad Dahlan Kota Jambi.</span>
        </div>
        <div class="footer-right">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>0822 4708 8451</span>
        </div>
    </div>

</body>
</html>