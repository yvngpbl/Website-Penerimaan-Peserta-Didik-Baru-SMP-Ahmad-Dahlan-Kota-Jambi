<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    // $guarded = ['id'] artinya semua kolom boleh diisi kecuali kolom 'id'
    Class "App\Models\Biodata" not found
LARAVEL
13.7.0
PHP
8.4.13
UNHANDLED
CODE 0
500
GET
http://127.0.0.1:8000/user/dashboard

Exception trace
2 vendor frames

Illuminate\Database\Eloquent\Model->hasOne(string)
app/Models/User.php:28

23    ];
24
25    // Relasi ke Biodata (1 User punya 1 Biodata)
26    public function biodata()
27    {
28        return $this->hasOne(Biodata::class);
29    }
30
31    // Relasi ke Pendaftaran/Berkas (1 User punya 1 Pendaftaran)
32    public function pendaftaran()
33    {
34        return $this->hasOne(Pendaftaran::class);
35    }
36
37    // Relasi ke Jadwal Tes (1 User punya 1 Jadwal)
38    public function jadwalTes()
39    {
    protected $guarded = ['id']; 

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}