<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            // Data Tambahan dari Dokumen Fisik
            $table->string('nisn')->nullable();
            $table->string('ttl_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('ttl_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            
            // Persetujuan & Digital Signature
            $table->boolean('setuju_biaya')->default(false);
            $table->boolean('setuju_peraturan')->default(false);
            $table->string('ttd_orang_tua')->nullable();
            $table->string('ttd_siswa')->nullable();
            $table->timestamp('tgl_persetujuan')->nullable();
            $table->text('alamat_lengkap')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn([
                'nisn', 'ttl_ayah', 'pekerjaan_ayah', 'ttl_ibu', 'pekerjaan_ibu',
                'setuju_biaya', 'setuju_peraturan', 'ttd_orang_tua', 'ttd_siswa', 'tgl_persetujuan', 'alamat_lengkap'
            ]);
        });
    }
};