<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Kelulusan - {{ $biodata->nama_lengkap }}</title>
    <style>
        /* Menggunakan font standar surat resmi */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 0 20px;
        }

        /* --- STYLING KOP SURAT --- */
        .kop-surat {
            width: 100%;
            margin-bottom: 5px;
        }
        .kop-surat td {
            vertical-align: middle;
            text-align: center;
        }
        .logo-sekolah {
            width: 90px; /* Sesuaikan ukuran logo */
            height: auto;
        }
        .teks-kop {
            line-height: 1.1;
        }
        .teks-kop .yayasan {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }
        .teks-kop .pimpinan {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
        }
        .teks-kop .nama-sekolah {
            font-size: 24pt;
            font-weight: bold;
            margin: 2px 0;
            letter-spacing: 1px;
        }
        .teks-kop .npsn {
            font-size: 12pt;
            margin: 0;
        }
        .teks-kop .alamat {
            font-size: 9pt;
            margin: 0;
        }

        /* Garis Bawah Kop Surat */
        .garis-kop-tebal {
            border: 0;
            border-top: 3px solid black;
            margin-top: 5px;
            margin-bottom: 1px;
        }
        .garis-kop-tipis {
            border: 0;
            border-top: 1px solid black;
            margin-top: 1px;
            margin-bottom: 20px;
        }

        /* --- STYLING ISI SURAT --- */
        .tabel-perihal {
            width: 100%;
            margin-bottom: 20px;
        }
        .tabel-perihal td {
            vertical-align: top;
        }
        .isi-surat {
            text-align: justify;
        }
        .tabel-biodata {
            width: 80%;
            margin: 15px auto;
        }
        .tabel-biodata td {
            padding: 3px 0;
            vertical-align: top;
        }

        /* Styling status LULUS */
        .status-lulus {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            letter-spacing: 2px;
            margin: 20px 0;
        }

        /* Styling Tanda Tangan */
        .ttd-container {
            width: 100%;
            margin-top: 40px;
        }
        .ttd-box {
            float: right;
            width: 300px;
            text-align: left;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <!-- BAGIAN KOP SURAT -->
    <table class="kop-surat">
        <tr>
            <!-- Kolom Logo Kiri -->
            <td width="15%">
                <!-- PENTING: Gunakan public_path() bukan asset() untuk DOMPDF -->
                <img src="{{ public_path('storage/images/logo2.png') }}" class="logo-sekolah" alt="Logo">
            </td>
            
            <!-- Kolom Teks Tengah -->
            <td width="85%" class="teks-kop">
                <p class="yayasan">MAJELIS PENDIDIKAN DASAR DAN MENENGAH</p>
                <p class="pimpinan">PIMPINAN CABANG MUHAMMADIYAH JELUTUNG</p>
                <p class="nama-sekolah">SMP AHMAD DAHLAN</p>
                <p class="npsn">NPSN : 69939934</p>
                <p class="alamat">Jl. Enggano Perumnas Kel. Handil Jaya Kec. Jelutung Kota Jambi 36137 E-mail:smpahmaddahlan2014@gmail.com</p>
            </td>
        </tr>
    </table>
    <!-- Garis Kop Surat (Tebal & Tipis) -->
    <hr class="garis-kop-tebal">
    <hr class="garis-kop-tipis">

    <!-- BAGIAN INFORMASI SURAT -->
    <table class="tabel-perihal">
        <tr>
            <td width="12%">Nomor</td>
            <td width="2%">:</td>
            <td width="56%">... /IV.4.AU/A/2026</td> <!-- Bisa disesuaikan dinamis jika ada fieldnya -->
            <td width="30%" style="text-align: right;">Jambi, {{ now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td colspan="2">-</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td colspan="2"><strong>Pengumuman Kelulusan SPMB</strong></td>
        </tr>
    </table>

    <!-- BAGIAN ALAMAT TUJUAN -->
    <p>Kepada Yth.<br>
    <strong>Bapak / Ibu Wali Murid / Calon Siswa</strong><br>
    di<br>
    Tempat</p>

    <!-- BAGIAN ISI SURAT -->
    <div class="isi-surat">
        <p><em>Assalamu'alaikum Warahmatullahi Wabarakatuh</em></p>
        <p>Semoga Bapak/Ibu/Wali murid SMP Ahmad Dahlan senantiasa dalam lindungan Allah SWT, Aamiin. Sehubungan dengan telah dilaksanakannya rangkaian proses Penerimaan Peserta Didik Baru (SPMB) SMP Ahmad Dahlan Tahun Ajaran 2026/2027, maka berdasarkan hasil evaluasi panitia, kami menyatakan bahwa data calon siswa berikut:</p>

        <!-- Tabel Biodata Siswa -->
        <table class="tabel-biodata">
            <tr>
                <td width="35%">Nama Lengkap</td>
                <td width="5%">:</td>
                <td width="60%"><strong>{{ $biodata->nama_lengkap }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $biodata->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>:</td>
                <td>{{ $biodata->asal_sekolah }}</td>
            </tr>
            <tr>
                <td>Jalur Pendaftaran</td>
                <td>:</td>
                <td>{{ $pendaftaran->kriteria }}</td>
            </tr>
        </table>

        <!-- Status Kelulusan -->
        <div class="status-lulus">
            <u>DINYATAKAN LULUS</u>
        </div>

        <p>Kami mengucapkan selamat bergabung menjadi bagian dari SMP Ahmad Dahlan. Diharapkan kepada Bapak/Ibu Wali Murid untuk segera menyelesaikan administrasi daftar ulang sesuai dengan jadwal yang telah ditentukan.</p>
        <p>Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kepercayaannya diucapkan terima kasih.</p>
        <p><em>Wassalamu'alaikum Warahmatullahi Wabarakatuh</em></p>
    </div>

    <!-- BAGIAN TANDA TANGAN -->
    <div class="ttd-container">
        <div class="ttd-box">
            <p style="margin-bottom: 70px;">
                Kepala Sekolah,<br>
                SMP Ahmad Dahlan Jambi
            </p>
            <p>
                <strong><u>ARDIANSYAH, S.Pd</u></strong><br>
                NBM. 1 257 800
            </p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>