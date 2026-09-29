
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi - SMP IT Ahmad Dahlan</title>
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
            min-height: 100vh; 
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

        /* --- STYLE KONTEN PRESTASI --- */
        .content-container { 
            max-width: 1200px; 
            margin: 50px auto; 
            padding: 20px; 
            text-align: center; 
            width: 100%;
            box-sizing: border-box;
        }
        .content-container h1 { text-transform: uppercase; color: #333; margin-bottom: 40px; font-size: 24px; }

        /* --- STYLE SLIDER GALERI --- */
        .slider-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .gallery-grid { 
            display: flex; 
            gap: 30px; 
            padding-bottom: 20px; 
            overflow-x: auto; 
            scroll-snap-type: x mandatory; 
            scroll-behavior: smooth;
            -ms-overflow-style: none;  
            scrollbar-width: none;  
            align-items: stretch; /* Agar tinggi card seragam menyesuaikan deskripsi */
        }
        .gallery-grid::-webkit-scrollbar { display: none; }

        .gallery-item { 
            width: 300px; /* Diperlebar agar muat deskripsi panjang */
            flex-shrink: 0; 
            scroll-snap-align: center; 
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .gallery-box { 
            width: 100%; 
            height: 220px; /* Tinggi foto / gambar prestasi */
            background-color: #e9ecef; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
            border-bottom: 4px solid #198754; 
            overflow: hidden; 
            display: flex; justify-content: center; align-items: center; 
        }

        .gallery-box img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }
        
        .gallery-item h4 { 
            margin-top: 20px; 
            margin-bottom: 5px;
            font-size: 18px; 
            color: #198754; 
            font-weight: bold; 
        } 
        
        /* Style untuk Deskripsi Prestasi */
        .prestasi-desc {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
            margin: 0;
            padding: 0 10px;
        }

        /* --- STYLE DOTS (TITIK NAVIGASI) --- */
        .dots-container { display: flex; justify-content: center; gap: 10px; margin-top: 20px; }
        .dot { 
            width: 12px; height: 12px; 
            border: 2px solid #198754; 
            border-radius: 50%; 
            background-color: transparent; 
            cursor: pointer; 
            transition: background-color 0.3s ease; 
        }
        .dot.active { background-color: #198754; }

        /* --- STYLE FOOTER --- */
        .footer { background-color: #333; color: white; text-align: center; display: flex; justify-content: space-between; align-items: center; padding: 20px; margin-top: auto; }
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
            .content-container h1 { font-size: 20px; margin-bottom: 25px; }
            
            .gallery-item { width: 280px; }

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
        <h1>Prestasi SMP IT Ahmad Dahlan Kota Jambi</h1>

        <div class="slider-wrapper">
            <div class="gallery-grid" id="slider">
                
                <div class="gallery-item">
                    <div class="gallery-box">
                        <img src="{{ asset('storage/images/prestasi1.jpg') }}" alt="Juara renang">
                    </div> 
                    <h4>Juara 1 Prestasi Renang</h4>
                    <p class="prestasi-desc">Prestasi Al Fath Maulana Toriq dalam Kejuaraan Pari Sakti Fun Swimming Jambi 2026 dengan meraih beberapa gelar juara pada berbagai kategori gaya renang putra.</p>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-box">
                        <img src="{{ asset('storage/images/prestasi2.jpg') }}" alt="Juara Tilawah">
                    </div>
                    <h4>Juara II Lomba Tilawah Al-Qur'an</h4>
                    <p class="prestasi-desc">Prestasi Riezki Aditia Putra, murid kelas VIII E SMP Ahmad Dahlan, yang berhasil meraih Juara 2 pada Lomba Tilawah Al-Qur’an tingkat SMP/MTs se-Kota Jambi dalam rangka Semarak Milad Muhammadiyah ke-113 Tahun 2025.</p>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-box">
                        <img src="{{ asset('storage/images/prestasi3.jpg') }}" alt="pencak silat">
                    </div>
                    <h4>Medali Emas Pencak Silat Siginjai Championship II 2026</h4>
                    <p class="prestasi-desc">Prestasi Alghafi Putra Langit yang berhasil meraih medali emas pada Kejuaraan Pencak Silat Siginjai Championship II Tahun 2026 di kelas tanding J.</p>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-box">
                        <img src="{{ asset('storage/images/prestasi4.jpg') }}" alt="Futsal">
                    </div>
                    <h4>Juara I Liga Futsal Championship 2025 Kota Jambi</h4>
                    <p class="prestasi-desc">Prestasi tim AHDA FC yang berhasil meraih Juara 1 pada Liga Futsal Championship 2025 tingkat Kota Jambi melalui semangat, kerja sama, dan sportivitas tim.</p>
                </div>
                
                <div class="gallery-item">
                    <div class="gallery-box">
                        <img src="{{ asset('storage/images/prestasi5.jpg') }}" alt="Cerdas Cermat">
                    </div>
                    <h4>Medali Emas kejuaraan Karate Open Piala Bupati Muaro Jambi Seprovinsi Jambi</h4>
                    <p class="prestasi-desc">Prestasi Azka Abimanyu Guntoro, murid kelas VIII SMP Ahmad Dahlan, yang berhasil meraih medali emas kategori Kumite +40 kg pada Kejuaraan Karate Open Piala Bupati Muaro Jambi tingkat Provinsi Jambi.</p>
                </div>

            </div>
        </div>

        <div class="dots-container" id="dots-container">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('slider');
            const dots = document.querySelectorAll('.dot');
            let isDown = false;
            let startX;
            let scrollLeft;

            // Fungsi update dot saat scroll
            slider.addEventListener('scroll', () => {
                let index = Math.round(slider.scrollLeft / (slider.children[0].offsetWidth + 30)); 
                dots.forEach((dot, i) => {
                    if (i === index) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
            });

            // Klik dot untuk geser gambar
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    const itemWidth = slider.children[0].offsetWidth + 30; 
                    slider.scrollTo({
                        left: index * itemWidth,
                        behavior: 'smooth'
                    });
                });
            });
            
            // Drag dengan mouse (Desktop)
            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.style.cursor = 'auto';
            });
            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.style.cursor = 'auto';
            });
            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2;
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    </script>

</body>
</html>