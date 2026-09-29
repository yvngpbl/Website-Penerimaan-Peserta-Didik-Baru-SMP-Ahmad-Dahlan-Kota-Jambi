
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register SPMB - SMP IT Ahmad Dahlan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#1a7e4b', /* Hijau utama navbar/tombol */
                        'brand-dark': '#136239',  /* Hijau gelap untuk hover */
                        'brand-light': '#eaf4ed', /* Hijau pucat untuk background */
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-brand-light font-sans text-gray-800 antialiased min-h-screen flex flex-col">

    <nav class="bg-brand-green text-white py-4 px-6 md:px-12 flex justify-between items-center shadow-md">
        <div class="text-xl font-bold tracking-wide">SMP IT Ahmad Dahlan</div>
        <a href="/" class="text-sm font-medium hover:text-gray-200 transition">&larr; Kembali</a>
    </nav>

    <div class="flex-grow flex items-center justify-center p-4 my-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl border-t-[6px] border-brand-green p-8">
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Form Pendaftaran Akun</h2>
                <p class="text-sm text-gray-500 mt-2">Buat akun menggunakan NISN untuk memulai pengisian berkas.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm" role="alert">
                    <span class="font-semibold block mb-1">Pendaftaran gagal:</span>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" required placeholder="Masukkan NISN Anda"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent transition duration-200">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Buat Password Baru"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent transition duration-200">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi Password"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-green focus:border-transparent transition duration-200">
                </div>
                
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-brand-green hover:bg-brand-dark text-white font-bold py-3 rounded-full shadow-md transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-brand-green hover:underline">Login di sini</a>
            </div>
            
        </div>
    </div>
    
</body>
</html>