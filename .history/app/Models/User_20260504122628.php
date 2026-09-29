<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    protected $fillable = [
        'nisn',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke Biodata (1 User punya 1 Biodata)
    public function biodata()
    {
        return $this->hasOne(Biodatamodel::class);
    }

    // Relasi ke Pendaftaran/Berkas (1 User punya 1 Pendaftaran)
    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }

    // Relasi ke Jadwal Tes (1 User punya 1 Jadwal)
    public function jadwalTes()
    {
        return $this->hasOne(JadwalTes::class);
    }
}