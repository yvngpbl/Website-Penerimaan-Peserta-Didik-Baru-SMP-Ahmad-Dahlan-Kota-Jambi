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
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Persetujuan Checklist
            $table->boolean('setuju_biaya_masuk')->default(false); // [cite: 25, 102]
            $table->boolean('setuju_peraturan_sekolah')->default(false); // [cite: 7, 21]
            
            // Penyimpanan Tanda Tangan Digital (Path Gambar)
            $table->string('ttd_siswa')->nullable(); // [cite: 91]
            $table->string('ttd_ayah')->nullable(); // [cite: 89]
            $table->string('ttd_ibu')->nullable(); // [cite: 89]
            
            // Data Tambahan dari Form (jika belum ada di biodata)
            $table->timestamp('tgl_persetujuan')->nullable(); // [cite: 88, 118]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            //
        });
    }
};
