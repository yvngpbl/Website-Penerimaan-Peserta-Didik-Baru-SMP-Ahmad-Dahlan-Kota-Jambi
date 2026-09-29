<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - SPMB SMP IT Ahmad Dahlan</title>
    <style>
        /* --- DITERAPKAN FLEXBOX PADA HTML & BODY AGAR FOOTER MENTOK BAWAH --- */
        html {
            height: 100%;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar { background-color: #198754; color: white; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .navbar h2 { margin: 0; font-size: 22px; }
        .navbar-links a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; padding: 8px 15px; border-radius: 5px; transition: background 0.3s; }
        .navbar-links a:hover { background-color: rgba(255, 255, 255, 0.1); }
        .navbar-links a.active { background-color: white; color: #198754; }
        .btn-logout { background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-size: 16px; margin-left: 20px; padding: 8px 15px; border-radius: 5px; }
        .btn-logout:hover { background-color: rgba(220, 53, 69, 0.8); }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
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

        /* Form Container - DITAMBAHKAN flex-grow: 1 AGAR MENDORONG FOOTER KE BAWAH */
        .container { 
            max-width: 900px; 
            margin: 40px auto; 
            background: white; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
            flex: 1 0 auto; 
            width: 100%;
            box-sizing: border-box;
        }
        .section-title { color: #198754; border-bottom: 2px solid #198754; padding-bottom: 10px; margin-top: 30px; margin-bottom: 20px; }
        
        /* Grid Layout untuk Form */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group.full-width { grid-column: span 2; }
        label { font-weight: bold; font-size: 14px; color: #555; display: block; margin-bottom: 5px; }
        input[type="text"], input[type="date"], input[type="file"], input[type="number"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-family: inherit; }
        
        /* Info Bank Box */
        .bank-info { background: #e8f5e9; padding: 20px; border-left: 5px solid #198754; margin-bottom: 30px; border-radius: 5px; }
        .bank-info h4 { margin-top: 0; color: #146c43; font-size: 18px; }
        .bank-info h3 { margin: 10px 0; letter-spacing: 1px; color: #333; }
        
        /* Submit Button */
        .btn-submit { background-color: #871987; color: white; padding: 15px 30px; border: none; border-radius: 50px; font-size: 18px; font-weight: bold; cursor: pointer; width: 100%; transition: background 0.3s; margin-top: 20px; }
        .btn-submit:hover { background-color: #146c43; }

        /* Style Tambahan untuk Pesan Tutup */
        .alert-tutup { background: #fff5f5; border: 2px dashed #dc3545; padding: 40px; border-radius: 10px; text-align: center; }
        .alert-tutup h2 { color: #dc3545; margin-top: 0; font-size: 26px; }
        .alert-tutup p { color: #555; font-size: 16px; line-height: 1.6; }
        .btn-kembali { display: inline-block; background-color: #6c757d; color: white; text-decoration: none; padding: 12px 25px; border-radius: 50px; font-weight: bold; margin-top: 20px; transition: background 0.3s; }
        .btn-kembali:hover { background-color: #5a6268; }

        /* Footer diperbarui */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            margin-top: auto; /* Memastikan footer terdorong ke paling bawah */
            box-sizing: border-box;
            width: 100%;
            flex-shrink: 0;
        }
        .footer-left, .footer-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           Semua kode media query disatukan di bawah agar efektif
           ======================================================= */
        @media (max-width: 768px) {
            /* Navbar Penyesuaian */
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
                margin-left: 0 !important;
                padding: 10px;
                font-size: 15px;
                display: block;
                text-align: center;
                width: 100%;
                box-sizing: border-box;
            }
            
            /* Dropdown & Logout di Mobile */
            .dropdown { width: 100%; }
            .dropdown-content {
                position: static;
                width: 100%;
                box-shadow: none;
                background-color: rgba(255, 255, 255, 0.95);
                margin-top: 5px;
            }
            .dropdown-content a { text-align: center; }
            form[action*="logout"] { width: 100%; }
            .btn-logout {
                margin-left: 0;
                width: 100%;
                display: block;
                padding: 12px;
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Container & Form Grid Penyesuaian */
            .container {
                margin: 20px auto;
                padding: 20px;
                width: calc(100% - 30px);
            }
            .form-grid {
                grid-template-columns: 1fr; /* Memaksa 1 kolom di HP */
                gap: 15px;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
            
            /* Penyesuaian Teks & Info Bank */
            h2[style*="text-align: center"] {
                font-size: 22px;
            }
            .section-title { font-size: 18px; }
            .bank-info { padding: 15px; }
            .bank-info h3 { font-size: 18px; }
            .btn-submit { font-size: 16px; padding: 12px 20px; }

            /* Penyesuaian Alert Tutup */
            .alert-tutup { padding: 25px 15px; }
            .alert-tutup h2 { font-size: 22px; }

            /* Footer Penyesuaian */
            .footer {
                flex-direction: column;
                gap: 15px;
                padding: 20px 15px;
            }
            .footer-left, .footer-right {
                justify-content: center;
                width: 100%;
                text-align: center;
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
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            
            
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
            <a href="{{ route('user.pendaftaran') }}" class="active">Daftar</a>
            <a href="{{ route('user.riwayat') }}">Riwayat</a>
            <a href="{{ route('user.kelulusan') }}">Pengumuman Kelulusan</a>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if($status === 'tutup')
            <div class="alert-tutup">
                <h2>🔒 Pendaftaran Online Ditutup</h2>
                <p>Mohon maaf, masa Penerimaan Peserta Didik Baru (PPDB) SMP IT Ahmad Dahlan saat ini sedang ditutup atau telah berakhir.</p>
                <p>Silakan hubungi sekretariat panitia atau pantau dashboard akun Anda secara berkala untuk informasi pembukaan gelombang berikutnya.</p>
                <a href="{{ route('user.dashboard') }}" class="btn-kembali">Kembali ke Dashboard</a>
            </div>
        @else
            <h2 style="text-align: center; color: #333; margin-top: 0;">Formulir Pendaftaran Siswa Baru</h2>
            
            <div class="bank-info">
                <h4>💳 Informasi Pembayaran Pendaftaran</h4>
                <p style="margin: 5px 0;">Biaya pendaftaran sebesar <strong>Rp 250.000</strong>. Silakan transfer ke rekening berikut:</p>
                <h3>BSI (Bank Syariah Indonesia) - 1234567890</h3>
                <p style="margin: 0; font-size: 14px;">a.n. SMP IT Ahmad Dahlan Jambi.</p>
            </div>

            @if(session('error'))
                <div style="background: #dc3545; color: white; padding: 12px; margin-bottom: 20px; border-radius: 5px; font-weight: bold;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('user.store_pendaftaran') }}" method="POST" enctype="multipart/form-data">
                @csrf

               <h3 class="section-title">A. Biodata Calon Siswa</h3>
    <div class="form-grid">
        <div class="form-group">
            <label>Nama Lengkap (Sesuai Ijazah)</label>
            <input type="text" name="nama_lengkap" required>
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>NISN</label>
            <input type="text" name="nisn" placeholder="10 Digit">
        </div>
        <div class="form-group">
            <label>NIK</label>
            <input type="text" name="nik" placeholder="Sesuai Kartu Keluarga">
        </div>
        <div class="form-group">
            <label>Asal Sekolah (SD)</label>
            <input type="text" name="asal_sekolah">
        </div>
        <div class="form-group">
            <label>Anak Ke-</label>
            <input type="number" name="anak_ke">
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir">
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir">
        </div>
        <div class="form-group">
            <label>Tinggal Bersama</label>
            <input type="text" name="tinggal_bersama" placeholder="Contoh: Orang Tua / Wali">
        </div>
        <div class="form-group">
            <label>Moda Transportasi</label>
            <input type="text" name="moda_transportasi" placeholder="Contoh: Motor / Antar Jemput">
        </div>
        <div class="form-group full-width">
            <label>Alamat Lengkap Domisili</label>
            <textarea name="alamat" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, kabupaten/provinsi Kode Pos"></textarea>
        </div>
    </div>

    <h3 class="section-title">B. Kriteria Pendaftaran (Pilih Salah Satu)</h3>
    <div class="form-grid" style="grid-template-columns: 1fr;">
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Umum" id="umum" required style="width: auto;" class="pilih-kriteria"> 
            <label for="umum" style="margin-bottom: 0;">Umum</label>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Anak Guru" id="anak_guru" style="width: auto;" class="pilih-kriteria"> 
            <label for="anak_guru" style="margin-bottom: 0;">Anak Guru (SD IT AD, SMP AD)</label>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Alumni" id="alumni" style="width: auto;" class="pilih-kriteria"> 
            <label for="alumni" style="margin-bottom: 0;">Alumni SD IT Ahmad Dahlan</label>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Saudara Kandung" id="saudara" style="width: auto;" class="pilih-kriteria"> 
            <label for="saudara" style="margin-bottom: 0;">Punya Saudara Kandung di SD IT / SMP AD</label>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Siswa Prestasi" id="prestasi" style="width: auto;" class="pilih-kriteria"> 
            <label for="prestasi" style="margin-bottom: 0;">Siswa Prestasi</label>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <input type="radio" name="kriteria" value="Siswa Yatim" id="yatim" style="width: auto;" class="pilih-kriteria"> 
            <label for="yatim" style="margin-bottom: 0;">Siswa Yatim</label>
        </div>
    </div>

    <h3 class="section-title">C. Data Periodik</h3>
    <div class="form-grid">
        <div class="form-group">
            <label>Tinggi Badan (cm)</label>
            <input type="number" name="tinggi_badan">
        </div>
        <div class="form-group">
            <label>Berat Badan (kg)</label>
            <input type="number" name="berat_badan">
        </div>
        <div class="form-group full-width">
            <label>Jumlah Saudara Kandung</label>
            <input type="number" name="jumlah_saudara">
        </div>
    </div>

    <h3 class="section-title">D. Data Ayah Kandung</h3>
    <div class="form-grid">
        <div class="form-group">
            <label>Nama Lengkap Ayah</label>
            <input type="text" name="nama_ayah">
        </div>
        <div class="form-group">
            <label>Tempat/Tanggal Lahir Ayah</label>
            <input type="text" name="tempat_lahir_ayah">
        </div>
        <div class="form-group">
            <label>Pendidikan Terakhir</label>
            <input type="text" name="pendidikan_ayah">
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan_ayah">
        </div>
        <div class="form-group">
            <label>Penghasilan Bulanan</label>
            <input type="text" name="penghasilan_ayah">
        </div>
        <div class="form-group">
            <label>No. HP Ayah (WhatsApp)</label>
            <input type="text" name="no_hp_ayah">
        </div>
    </div>

    <h3 class="section-title">E. Data Ibu Kandung</h3>
    <div class="form-grid">
        <div class="form-group">
            <label>Nama Lengkap Ibu</label>
            <input type="text" name="nama_ibu">
        </div>
        <div class="form-group">
            <label>Tempat/Tanggal Lahir Ibu</label>
            <input type="text" name="tempat_lahir_ibu">
        </div>
        <div class="form-group">
            <label>Pendidikan Terakhir</label>
            <input type="text" name="pendidikan_ibu">
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" name="pekerjaan_ibu">
        </div>
        <div class="form-group">
            <label>Penghasilan Bulanan</label>
            <input type="text" name="penghasilan_ibu">
        </div>
        <div class="form-group">
            <label>No. HP Ibu (WhatsApp)</label>
            <input type="text" name="no_hp_ibu">
        </div>
    </div>

                <h3 class="section-title">F. Upload Berkas Persyaratan (Format PDF/Foto)</h3>
    <p style="font-size: 13px; color: #dc3545; margin-top: -10px; margin-bottom: 20px;">*Maksimal ukuran file 2MB per item.</p>

    <div class="form-grid">
        <div class="form-group">
            <label>1. Scan Raport Terakhir</label>
            <input type="file" name="file_raport" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="form-group">
            <label>2. Pas Foto Calon Siswa (Berwarna)</label>
            <input type="file" name="pas_foto" accept=".jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label>3. Scan SKL (Surat Keterangan Lulus)</label>
            <input type="file" name="file_skl" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="form-group">
            <label>4. Scan Ijazah (Jika sudah ada)</label>
            <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label>5. Scan Akte Kelahiran</label>
            <input type="file" name="file_akte" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="form-group">
            <label>6. Scan Kartu Keluarga (KK)</label>
            <input type="file" name="file_kk" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label>7. Scan KTP Orang Tua</label>
            <input type="file" name="ktp_ortu" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="form-group">
            <label>8. Scan Surat Keterangan Sehat</label>
            <input type="file" name="file_keterangan_sehat" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="form-group" id="form-piagam" style="display: none;">
            <label>9. Scan Piagam/Sertifikat (Jalur Prestasi)</label>
            <input type="file" name="file_piagam" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="form-group" id="form-yatim" style="display: none;">
            <label>10. Scan Ket. Yatim (Jalur Siswa Yatim)</label>
            <input type="file" name="file_keterangan_yatim" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="form-group full-width" style="background: #f8f9fa; padding: 20px; border: 2px dashed #198754; border-radius: 5px; margin-top: 10px;">
            <label style="color: #198754; font-size: 16px;">11. Upload Bukti Pembayaran Pendaftaran (Wajib)</label>
            <input type="file" name="bukti_pembayaran" required accept=".pdf,.jpg,.jpeg,.png" style="border: none; padding-left: 0;">
            <small style="color: #666; display: block; margin-top: 5px;">*Pastikan bukti transfer terlihat jelas senilai Rp 250.000</small>
        </div>
    </div>

                <button type="submit" class="btn-submit">Kirim Formulir &amp; lanjutkan</button>
            </form>
        @endif
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
document.addEventListener('DOMContentLoaded', function () {
    const kriteriaRadios = document.querySelectorAll('.pilih-kriteria');
    const formPiagam = document.getElementById('form-piagam');
    const formYatim = document.getElementById('form-yatim');

    kriteriaRadios.forEach(radio => {
        radio.addEventListener('change', function (e) {
            // Sembunyikan keduanya setiap ada pilihan baru
            formPiagam.style.display = 'none';
            formYatim.style.display = 'none';

            // Tampilkan sesuai nilai (value) yang dipilih pendaftar
            if (e.target.value === 'Siswa Prestasi') {
                formPiagam.style.display = 'block';
            } else if (e.target.value === 'Siswa Yatim') {
                formYatim.style.display = 'block';
            }
        });
    });

    // --- FITUR BARU: VALIDASI UKURAN FILE MAKSIMAL 2MB ---
    const fileInputs = document.querySelectorAll('input[type="file"]');
    const maxFileSize = 2 * 1024 * 1024; // 2MB dalam bytes

    fileInputs.forEach(input => {
        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const fileSize = this.files[0].size;
                
                if (fileSize > maxFileSize) {
                    alert('Gagal! Ukuran file "' + this.files[0].name + '" terlalu besar.\n\nMaksimal ukuran yang diizinkan adalah 2MB. Silakan kompres atau pilih file lain.');
                    
                    // Kosongkan kembali input file agar tidak ikut tersubmit
                    this.value = '';
                }
            }
        });
    });
    // -----------------------------------------------------
});
</script>

</body>
</html>