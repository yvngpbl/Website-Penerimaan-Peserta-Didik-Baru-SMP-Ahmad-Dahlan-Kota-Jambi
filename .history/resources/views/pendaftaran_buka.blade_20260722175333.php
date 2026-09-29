<!-- 
    FILE: pendaftaran_buka.blade.php
    FUNGSI: Halaman yang muncul jika status pendaftaran DIBUKA.
    MENAMPILKAN: Informasi bank BSI Rp 250.000 dan tempat upload form biodata/berkas.
    CATATAN: Masih menggunakan placeholder <em>(Form input biodata akan diletakkan di sini)</em>.
    EXTENDS: user.dashboard (menggunakan layout dashboard user).
-->
@extends('user.dashboard')

@section('content')
<div style="max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h2 style="color: #198754; border-bottom: 2px solid #198754; padding-bottom: 10px;">Formulir Pendaftaran & Upload Berkas</h2>
    
    <!-- Informasi Bank -->
    <div style="background: #e8f5e9; padding: 15px; border-left: 5px solid #198754; margin-bottom: 25px; border-radius: 5px;">
        <h4 style="margin-top: 0; color: #146c43;">💳 Informasi Pembayaran Formulir</h4>
        <p style="margin: 5px 0;">Silakan transfer biaya pendaftaran sebesar <strong>Rp 250.000</strong> ke rekening berikut:</p>
        <h3 style="margin: 10px 0; letter-spacing: 2px;">BSI (Bank Syariah Indonesia) - 1234567890</h3>
        <p style="margin: 0; font-size: 14px;">a.n. SMP IT Ahmad Dahlan Jambi. <br><em>Simpan bukti transfer Anda untuk diunggah pada form di bawah.</em></p>
    </div>

    <!-- Nanti di sini kita buatkan tag <form> panjang untuk input Biodata (Nama, TTL) dan Berkas (Raport, Bukti Bayar, dll) -->
    <p><em>(Form input biodata dan upload file akan diletakkan di sini)</em></p>
    
</div>
@endsection