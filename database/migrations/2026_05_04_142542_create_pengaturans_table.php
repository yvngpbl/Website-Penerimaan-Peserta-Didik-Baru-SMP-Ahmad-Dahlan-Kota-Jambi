<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('kunci')->unique(); // Contoh: 'status_pendaftaran'
            $table->string('nilai');           // Contoh: 'buka' atau 'tutup'
            $table->timestamps();
        });

        // Isi data awal (seeding langsung) agar tidak kosong
        DB::table('pengaturans')->insert([
            'kunci' => 'status_pendaftaran',
            'nilai' => 'buka',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};