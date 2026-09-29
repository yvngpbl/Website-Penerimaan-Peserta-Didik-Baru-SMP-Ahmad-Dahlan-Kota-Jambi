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
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
        
        // Berkas Persyaratan
        $table->string('file_raport');
        $table->string('file_skl');
        $table->string('file_akte');
        $table->string('file_kk');
        $table->string('file_ijazah');
        $table->string('pas_foto');
        $table->string('ktp_ortu');
        $table->string('bukti_pembayaran');
        
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
