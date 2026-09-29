<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Jika kombinasi NISN dan Password benar
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek role untuk redirect ke dashboard masing-masing
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            // Jika bukan admin, berarti user (siswa)
            return redirect()->intended('/user/dashboard');
        }

        // Jika gagal login, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'nisn' => 'NISN atau Password yang Anda masukkan salah.',
        ])->onlyInput('nisn');
    }

    // Menampilkan halaman form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses data pendaftaran akun baru
    public function register(Request $request)
    {
        $request->validate([
            // Catatan: Jika tabel di databasemu bernama 'user' (tanpa s), ubah 'unique:users,nisn' menjadi 'unique:user,nisn'
            'nisn' => ['required', 'string', 'max:20', 'unique:users,nisn'],
            'password' => ['required', 'min:6', 'confirmed'], 
        ], [
            // Kumpulan pesan error berbahasa Indonesia
            'nisn.required' => 'Kolom NISN wajib diisi.',
            'nisn.unique' => 'NISN ini sudah terdaftar. Silakan login atau gunakan NISN lain.',
            'nisn.max' => 'NISN maksimal 20 karakter.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok. Silakan ketik ulang dengan benar.',
        ]);

        // Simpan data ke database
        User::create([
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
            'role' => 'user', // Otomatis diset sebagai user (calon siswa)
        ]);

        // Arahkan ke halaman login setelah berhasil mendaftar
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silahkan login dengan NISN Anda.');
    }

    // Memproses fitur keluar (logout)
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/'); // Kembali ke halaman utama (Landing Page)
    }
}