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
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nama_lengkap');
        $table->string('jenis_kelamin')->nullable();
        $table->string('nisn')->nullable();
        $table->string('asal_sekolah')->nullable();
        $table->string('nik')->nullable();
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->string('tinggal_bersama')->nullable();
        $table->string('moda_transportasi')->nullable();
        $table->string('anak_ke')->nullable();
        
        // Data Periodik
        $table->integer('tinggi_badan')->nullable();
        $table->integer('berat_badan')->nullable();
        $table->integer('jumlah_saudara')->nullable();
        
        // Data Orang Tua (Berdasarkan Formulir Wajib Isi)
        $table->string('nama_ayah')->nullable();
        $table->string('tempat_lahir_ayah')->nullable();
        $table->string('pendidikan_ayah')->nullable();
        $table->string('pekerjaan_ayah')->nullable();
        $table->string('penghasilan_ayah')->nullable();
        $table->string('no_hp_ayah')->nullable();

        $table->string('nama_ibu')->nullable();
        $table->string('tempat_lahir_ibu')->nullable();
        $table->string('pendidikan_ibu')->nullable();
        $table->string('pekerjaan_ibu')->nullable();
        $table->string('penghasilan_ibu')->nullable();
        $table->string('no_hp_ibu')->nullable();
        
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
