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
        Schema::create('jadwal_tes', function (Blueprint $table) {
            $table->id();
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
            $table->date('tanggal_tes');
            $table->time('waktu_tes');
            $table->string('ruangan_atau_tempat');
            $table->string('jenis_tes')->default('Wawancara & Tes Ngaji');
            $table->text('catatan_tambahan')->nullable()->comment('Misal: Bawa alat tulis dan Al-Quran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_tes');
    }
};
