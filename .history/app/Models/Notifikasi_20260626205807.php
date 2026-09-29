<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi'; 

    // Tambahkan baris ini agar bisa di-insert
    protected $fillable = ['user_id', 'pesan', 'status_lulus'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}