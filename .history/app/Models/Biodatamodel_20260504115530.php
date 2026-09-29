<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    // $guarded = ['id'] artinya semua kolom boleh diisi kecuali kolom 'id'
    protected $table = 'biodata';
    protected $guarded = ['id']; 

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}