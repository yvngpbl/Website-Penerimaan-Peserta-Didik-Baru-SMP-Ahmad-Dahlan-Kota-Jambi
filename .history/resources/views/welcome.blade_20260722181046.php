<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB - SMP IT Ahmad Dahlan Kota Jambi</title>
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
            background-color: #198754; /* Hijau khas sekolah Islam */
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
        .navbar-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar-links a.btn-login {
            background-color: white;
            color: #198754;
        }
        .navbar-links a.btn-login:hover {
            background-color: #e2e6ea;
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 100px 20px; /* Padding saya tambah sedikit agar background lebih terlihat */
            
            /* --- TAMBAHAN BACKGROUND IMAGE --- */
            /* linear-gradient digunakan untuk memberi lapisan warna hijau transparan agar teks tetap terbaca */
            background-image: linear-gradient(rgba(232, 245, 233, 0.85), rgba(232, 245, 233, 0.85)), url('{{ asset("storage/images/fotosekolah1.jpg") }}');
            background-size: cover; /* Agar gambar memenuhi seluruh area */
            background-position: center; /* Agar gambar berada di tengah */
            background-repeat: no-repeat; /* Menghindari gambar berulang */
            /* --------------------------------- */
            
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
        .btn-register {
            background-color: #198754;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border-radius: 50px;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.3);
            transition: background 0.3s;
        }
        .btn-register:hover {
            background-color: #146c43;
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
            padding: 20px;
            margin-top: 40px;
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
        }

        /* =========================================================
           TAMBAHAN CSS RESPONSIVE UNTUK TAMPILAN MOBILE & TABLET 
           ========================================================= */
        @media (max-width: 768px) {
            /* Menyesuaikan Navbar agar turun ke bawah (stacking) di layar kecil */
            .navbar {
                flex-direction: column;
                padding: 15px 20px;
                gap: 15px;
                text-align: center;
            }
            .navbar-links {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }
            .navbar-links a, .btn-logout {
                margin-left: 0;
                width: 100%;
                box-sizing: border-box;
                display: block;
                padding: 10px;
            }
            
            /* Menyesuaikan ukuran teks dan jarak di Hero Section */
            .hero {
                padding: 60px 15px;
            }
            .hero h1 {
                font-size: 28px;
            }
            .hero p {
                font-size: 15px;
                margin-bottom: 25px;
            }
            .btn-register {
                font-size: 16px;
                padding: 12px 25px;
                display: inline-block;
            }

            /* Menyesuaikan jarak dan memastika Grid menjadi 1 kolom di HP */
            .info-section {
                padding: 30px 15px;
            }
            .info-section h3 {
                font-size: 24px;
                margin-bottom: 25px;
            }
            .grid-alur {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- 
        NAVBAR: Navigasi atas.
        - @auth: Mengecek apakah user sudah login. Jika sudah login, tampilkan link ke dashboard sesuai role-nya.
        - @if(Auth::user()->role == 'admin'): Jika role admin, arahkan ke route('admin.dashboard').
        - @else: Jika role user biasa, arahkan ke route('user.dashboard').
        - @else (guest): Jika belum login, tampilkan tombol Login.
    -->
    <div class="navbar">
        <h2>SMP IT Ahmad Dahlan</h2>
        <div class="navbar-links">
            @auth
                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}">Dashboard Saya</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display: inline; width: 100%;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Masuk (Login)</a>
            @endauth
            
        </div>
    </div>

    <!-- 
        HERO SECTION: Bagian sambutan utama.
        - @guest: Jika belum login, tampilkan tombol "Daftar Sekarang" yang mengarah ke halaman register.
        - @else: Jika sudah login, tampilkan teks "Anda sudah masuk ke dalam sistem".
        - Background menggunakan gambar sekolah dengan overlay hijau transparan (linear-gradient).
    -->
    <div class="hero">
        <h1>Penerimaan Peserta Didik Baru (SPMB)</h1>
        <p>Selamat datang di portal resmi pendaftaran siswa baru SMP IT Ahmad Dahlan Kota Jambi Tahun Ajaran 2026/2027. Mari bergabung dan mencetak generasi Islami yang cerdas dan berprestasi.</p>
        
        @guest
            <a href="{{ route('register') }}" class="btn-register">Daftar Sekarang</a>
        @else
            <p style="color: #198754; font-weight: bold;">Anda sudah masuk ke dalam sistem.</p>
        @endguest
    </div>

    <!-- Bagian Alur Pendaftaran -->
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

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2026 Sistem Informasi SPMB - SMP IT Ahmad Dahlan Kota Jambi.</p>
    </div>

</body>
</html>