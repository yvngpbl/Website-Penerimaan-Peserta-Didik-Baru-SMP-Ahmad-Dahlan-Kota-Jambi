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
        Schema::create('biodata', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
    $table->string('nama_lengkap'); [cite: 11]
    $table->string('jenis_kelamin')->nullable(); [cite: 12]
    $table->string('nisn')->nullable(); [cite: 13]
    $table->string('asal_sekolah')->nullable(); [cite: 14]
    $table->string('nik')->nullable(); [cite: 15]
    $table->string('tempat_lahir')->nullable(); [cite: 16]
    $table->date('tanggal_lahir')->nullable(); [cite: 16]
    
    // Alamat Lengkap
    $table->text('alamat')->nullable(); [cite: 17, 18]
    $table->string('rt_rw')->nullable(); [cite: 19]
    $table->string('kelurahan_kecamatan')->nullable(); [cite: 20]
    $table->string('kabupaten_provinsi')->nullable(); [cite: 21]
    $table->string('kode_pos')->nullable(); [cite: 22]
    
    // Data Periodik
    $table->integer('tinggi_badan')->nullable(); [cite: 29]
    $table->integer('berat_badan')->nullable(); [cite: 32]
    
    // Data Orang Tua (Ayah & Ibu)
    $table->string('nama_ayah')->nullable(); [cite: 37]
    $table->string('pekerjaan_ayah')->nullable(); [cite: 40]
    $table->string('no_hp_ayah')->nullable(); [cite: 42]
    $table->string('nama_ibu')->nullable(); [cite: 44]
    $table->string('no_hp_ibu')->nullable(); [cite: 49]
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
