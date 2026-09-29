<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans'; // Menyesuaikan nama tabel jika jamak
    protected $fillable = ['nama_pengaturan', 'nilai'];
}