
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi Misi - SMP IT Ahmad Dahlan</title>
    <style>
        /* --- KUNCI FOOTER DI BAWAH --- */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f8f9fa; 
            color: #333; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; /* Memastikan body setinggi layar */
        }
        
        /* --- STYLE NAVBAR --- */
        .navbar { background-color: #198754; color: white; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .navbar h2 { margin: 0; font-size: 22px; }
        .navbar-brand { display: flex; align-items: center; gap: 15px; }
        .navbar-links a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .navbar-links a:hover { background-color: rgba(255, 255, 255, 0.1); }
        .navbar-links a.active { background-color: white; color: #198754; }
        .logo-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; background-color: white; border: 2px solid white; }
        .btn-logout { background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-family: inherit; font-size: 16px; margin-left: 20px; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .btn-logout:hover { background-color: rgba(220, 53, 69, 0.8); }

        /* --- CSS DROPDOWN INFORMASI --- */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { display: none; position: absolute; background-color: white; min-width: 220px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1); z-index: 1000; border-radius: 5px; margin-top: 10px; overflow: hidden; }
        .dropdown-content a { color: #333 !important; padding: 12px 16px !important; text-decoration: none; display: block; margin: 0 !important; font-weight: bold; font-size: 14px !important; border-bottom: 1px solid #eee; border-radius: 0 !important; transition: background 0.3s; }
        .dropdown-content a:hover { background-color: #e8f5e9 !important; color: #198754 !important; }
        .dropdown:hover .dropdown-content { display: block; }

        /* --- STYLE KONTEN VISI MISI --- */
        .content-container { 
            max-width: 1000px; 
            margin: 50px auto; 
            padding: 20px; 
            width: 100%;
            box-sizing: border-box;
        }
        .page-header { text-align: center; margin-bottom: 40px; }
        .page-header h1 { color: #333; margin-bottom: 5px; }
        
        .sekilas-text { 
            width: 100%; 
            background-color: white; 
            padding: 40px; 
            line-height: 1.8; 
            font-weight: 500; 
            font-size: 16px; 
            box-sizing: border-box;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-top: 4px solid #198754;
            color: #444;
        }

        /* --- STYLE FOOTER --- */
        .footer { 
            background-color: #333; 
            color: white; 
            text-align: center; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 20px; 
            margin-top: auto; /* KUNCI: Mendorong footer otomatis ke paling bawah layar */
        }
        .footer-left, .footer-right { display: flex; align-items: center; gap: 10px; }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            .navbar { padding: 15px; flex-direction: column; gap: 15px; align-items: center; }
            .navbar-brand { width: 100%; justify-content: center; }
            .navbar-brand h2 { font-size: 20px; text-align: center; }
            .navbar-links { width: 100%; display: flex; flex-direction: column; gap: 8px; }
            .navbar-links a { margin-left: 0; padding: 10px; text-align: center; width: 100%; display: block; box-sizing: border-box; }
            
            .dropdown { width: 100%; }
            .dropdown-content { position: static; width: 100%; box-shadow: none; margin-top: 5px; }
            .dropdown-content a { text-align: center; }
            form[action*="logout"] { width: 100%; }
            .btn-logout { margin-left: 0; width: 100%; display: block; padding: 12px; background-color: rgba(255,255,255,0.1); }

            .content-container { margin: 20px auto; padding: 15px; }
            .page-header h1 { font-size: 20px; }
            .sekilas-text { padding: 20px; font-size: 14px; }
            
            .footer { flex-direction: column; gap: 15px; padding: 20px 15px; }
            .footer-left, .footer-right { justify-content: center; width: 100%; }
            .footer-center { font-size: 14px; line-height: 1.5; }
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
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            
            <div class="dropdown">
                <a href="#" class="active" style="cursor: pointer;">Informasi <span class="dropdown-icon">&#x25BC;</span></a>
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

    <div class="content-container">
        <div class="page-header">
            <h1 style="text-transform: uppercase;">Visi & Misi SMP IT Ahmad Dahlan Kota Jambi</h1>
        </div>

        <div class="sekilas-text" style="text-align: left;">
            <h3 style="margin-top: 0; color: #198754;">VISI :</h3>
            <p>"Terwujudnya Sekolah Sehat, Guru Hebat, Murid Berbakat Dan Berakhlak Mulia"</p>

            <h3 style="margin-top: 30px; color: #198754;">MISI :</h3>
            <ol style="padding-left: 20px;">
                <li>Mewujudkan Lingkungan Sekolah Yang indah Bersih, Sehat, Aman Dan Nyaman.</li>
                <li>Menyelenggarakan Pendidikan Yang Berkualitas Dengan Kurikulum Yang Mengintegrasikan Ilmu Pengetahuan Umum Dan Nilai Nilai Ke Muhammdiyaan.</li>
                <li>Memberikan Pelatihan Dengan Memfasilitasi Pengembangan Professional Bagi Para Guru Untuk Meningkatkan Kompetensi Dan Professionalisme Dalam Mendidik Dan Mengajar.</li>
                <li>Menyedikan Pendekatan Pembelajaran Yang Sesuai Dengan Kebutuhan, Minat, Dan Gaya Belajar Setiap Murid.</li>
                <li>Memastikan Kesejahteraan Finansial Guru Dan Staff Serta Progam Penghargaan Untuk Guru Berprestasi.</li>
                <li>Mendorong Dan Memfasilitasi Pengembangan Minat Dan Bakat Murid Untuk Mencapai Prestasi Baik Di Bidang Akademik Maupun Non Akademik.</li>
                <li>Menerapkan Pembelajaran Yang Berbasis Al-Qur'an Dan Hadist Bagi Murid.</li>
                <li>Menjadi Teladan Dalam Perilaku Dan Tindakan Sehari-hari Dengan Menunjukkan Sikap Serta Akhlak Yang Baik Oleh Seluruh Warga Sekolah.</li>
            </ol>
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