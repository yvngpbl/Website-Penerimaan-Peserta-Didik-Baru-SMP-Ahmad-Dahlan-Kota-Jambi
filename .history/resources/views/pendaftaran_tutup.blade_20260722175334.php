<!-- 
    FILE: pendaftaran_tutup.blade.php
    FUNGSI: Halaman yang muncul jika status pendaftaran DITUTUP.
    MENAMPILKAN: Pesan peringatan "Mohon Maaf, Pendaftaran Sedang Ditutup" dengan ikon ⛔.
    CATATAN: Halaman ini statis, hanya memberi tahu user bahwa pendaftaran sedang tidak aktif.
-->
@extends('user.dashboard')

@section('content')
<div style="text-align: center; padding: 50px 20px;">
    <h1 style="color: #dc3545; font-size: 50px;">⛔</h1>
    <h2 style="color: #333;">Mohon Maaf, Pendaftaran Sedang Ditutup</h2>
    <p style="color: #666; font-size: 18px;">Saat ini gelombang pendaftaran belum dibuka atau sudah berakhir. <br>Silakan pantau terus informasi terbaru dari Admin.</p>
    <a href="{{ route('user.dashboard') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background: #198754; color: white; text-decoration: none; border-radius: 5px;">Kembali ke Beranda</a>
</div>
@endsection