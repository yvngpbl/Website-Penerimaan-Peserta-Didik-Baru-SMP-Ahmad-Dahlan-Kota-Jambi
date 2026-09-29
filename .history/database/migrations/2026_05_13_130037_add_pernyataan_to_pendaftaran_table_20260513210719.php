<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
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
            $table->dropColumn(['setuju_biaya', 'setuju_peraturan', 'ttd_orang_tua', 'ttd_siswa', 'tgl_persetujuan']);
        });
    }
};