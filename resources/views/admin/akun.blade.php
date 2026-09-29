<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Pendaftar - Admin SPMB</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #f8f9fa; display: flex; min-height: 100vh; }

        /* --- SIDEBAR & TOPBAR (Tetap Sama) --- */
        .sidebar { width: 250px; background-color: #dc3545; color: white; position: fixed; height: 100%; box-shadow: 2px 0 5px rgba(0,0,0,0.1); display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 20px; text-align: center; font-size: 20px; font-weight: bold; border-bottom: 1px solid rgba(255, 255, 255, 0.2); background-color: #c82333; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-menu a { color: white; text-decoration: none; padding: 15px 25px; display: block; font-weight: 500; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid white; padding-left: 21px; }
        .main-wrapper { flex: 1; margin-left: 250px; display: flex; flex-direction: column; }
        .topbar { background-color: white; padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .btn-logout { background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; }

        /* --- KONTEN BARU --- */
        .content { padding: 30px; }
        .stats-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat-box { background: white; padding: 20px; border-radius: 8px; border-left: 5px solid #dc3545; flex: 1; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .search-container { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .search-container input { padding: 10px; width: 300px; border: 1px solid #ced4da; border-radius: 5px; }
        
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { background-color: #f4f6f9; color: #333; text-transform: uppercase; font-size: 13px; }
        
        .badge { padding: 5px 10px; border-radius: 50px; font-size: 12px; font-weight: bold; color: white; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-success { background-color: #198754; }
        .btn-delete { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">Panel Admin SPMB</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.akun') }}" class="active">Akun Pendaftar</a></li>
            <li><a href="{{ route('admin.pendaftaran') }}">Pendaftaran</a></li>
            <li><a href="{{ route('admin.kelulusan') }}">Kelulusan</a></li>
            <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-logout">Logout</button></form>
        </div>

        <div class="content">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;">{{ session('success') }}</div>
            @endif

            <div class="stats-row">
                <div class="stat-box"><h4>Total Akun</h4><h2>{{ $akuns->count() }}</h2></div>
                <div class="stat-box"><h4>Sudah Isi Profil</h4><h2>{{ $akuns->whereNotNull('biodata')->count() }}</h2></div>
                <div class="stat-box"><h4>Belum Isi Profil</h4><h2>{{ $akuns->whereNull('biodata')->count() }}</h2></div>
            </div>

            <div class="search-container">
                <h3 style="margin:0">Manajemen Akun</h3>
                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari berdasarkan nama atau NISN...">
            </div>

            <div class="card">
                <table id="akunTable">
                    <thead>
                        <tr>
                            <th>No</th><th>Nama Pendaftar</th><th>NISN</th><th>Email</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($akuns as $index => $akun)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $akun->biodata->nama_lengkap ?? 'Belum Diatur' }}</strong></td>
                            <td>{{ $akun->biodata->nisn ?? '-' }}</td>
                            <td>{{ $akun->email }}</td>
                            <td>{{ $akun->created_at->format('d M Y') }}</td>
                            <td>
                                @if($akun->biodata) <span class="badge badge-success">Lengkap</span>
                                @else <span class="badge badge-warning">Kosong</span> @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.akun.destroy', $akun->id) }}" method="POST" onsubmit="return confirm('Hapus permanen akun ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus Akun</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("akunTable");
            let tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let name = tr[i].getElementsByTagName("td")[1].textContent.toLowerCase();
                let nisn = tr[i].getElementsByTagName("td")[2].textContent.toLowerCase();
                tr[i].style.display = (name.includes(input) || nisn.includes(input)) ? "" : "none";
            }
        }
    </script>
</body>
</html>