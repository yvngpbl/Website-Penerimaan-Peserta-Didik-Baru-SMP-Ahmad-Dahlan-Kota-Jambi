<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            // Sesuaikan ke 'users' jika itu nama tabel user Anda di database
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Penambahan kolom Kriteria (Umum, Anak Guru, Siswa Yatim, dll) [cite: 1, 7]
            $table->string('kriteria')->nullable(); 
        
            // Berkas Persyaratan (Sesuai dokumen persyaratan) [cite: 59, 60, 61]
            $table->string('file_raport')->nullable();
            $table->string('file_skl')->nullable();
            $table->string('file_akte')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('pas_foto')->nullable();
            $table->string('ktp_ortu')->nullable();
            $table->string('file_keterangan_sehat')->nullable();
            $table->string('file_keterangan_yatim')->nullable();
            $table->string('file_piagam')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            
            // Tracking Status Verifikasi Berkas
            $table->enum('status_verifikasi', ['belum_diperiksa', 'berhasil', 'ditolak'])->default('belum_diperiksa');
            $table->text('catatan_verifikasi')->nullable();
            
            // Tracking Status Kelulusan
            $table->enum('status_lulus', ['menunggu', 'lulus', 'tidak_lulus'])->default('menunggu');
            $table->text('catatan_lulus')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};