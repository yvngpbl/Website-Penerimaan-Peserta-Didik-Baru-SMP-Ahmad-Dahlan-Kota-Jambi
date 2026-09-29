
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SPMB</title>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background: #f8f9fa; display: flex; min-height: 100vh; }

        /* --- SIDEBAR KIRI --- */
        .sidebar { width: 250px; background-color: #dc3545; color: white; position: fixed; height: 100%; box-shadow: 2px 0 5px rgba(0,0,0,0.1); display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 20px; text-align: center; font-size: 20px; font-weight: bold; border-bottom: 1px solid rgba(255, 255, 255, 0.2); background-color: #c82333; }
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li { border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .sidebar-menu a { color: white; text-decoration: none; padding: 15px 25px; display: block; font-weight: 500; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: rgba(255, 255, 255, 0.1); border-left: 4px solid white; padding-left: 21px; }

        /* --- AREA KONTEN UTAMA --- */
        .main-wrapper { flex: 1; margin-left: 250px; display: flex; flex-direction: column; }
        .topbar { background-color: white; padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .btn-logout { background: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background: #c82333; }

        /* --- KONTEN DASHBOARD --- */
        .content { padding: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #dc3545; display: flex; justify-content: space-between; align-items: center; }
        .border-blue { border-left-color: #0d6efd; }
        .border-yellow { border-left-color: #ffc107; }
        .border-green { border-left-color: #198754; }
        .border-red { border-left-color: #dc3545; }
        .border-purple { border-left-color: #6f42c1; }

        .stat-info h4 { margin: 0; color: #666; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-info h2 { margin: 5px 0 0 0; color: #333; font-size: 28px; }
        .stat-icon { font-size: 35px; opacity: 0.2; }

        .content-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-top: 4px solid #dc3545; }
        .card-title { margin-top: 0; margin-bottom: 20px; color: #333; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;}
        
        .info-list { list-style: none; padding: 0; margin: 0; }
        .info-list li { padding: 12px 0; border-bottom: 1px dashed #eee; display: flex; justify-content: space-between; font-size: 14px; color: #555;}
        .info-list li:last-child { border-bottom: none; }
        
        .badge { padding: 5px 10px; border-radius: 50px; font-size: 12px; font-weight: bold; color: white;}
        .badge-success { background-color: #198754; }
        .badge-danger { background-color: #dc3545; }

        .btn-toggle { display: block; width: 100%; padding: 10px; margin-top: 15px; border: none; background-color: #ffc107; color: #000; font-weight: bold; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn-toggle:hover { background-color: #e0a800; }

        @media (max-width: 900px) { .content-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">Panel Admin SPMB</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('admin.akun') }}">Akun Pendaftar</a></li>
            <li><a href="{{ route('admin.pendaftaran') }}">Pendaftaran</a></li>
            <li><a href="{{ route('admin.kelulusan') }}">Kelulusan</a></li>
            <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="topbar">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="content">
            
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="stats-grid">
                <div class="stat-card border-blue">
                    <div class="stat-info"><h4>Total Akun</h4><h2>{{ $totalAkun }}</h2></div>
                    <div class="stat-icon" style="color: #0d6efd;">👤</div>
                </div>

                <div class="stat-card border-yellow">
                    <div class="stat-info"><h4>Total Pendaftar</h4><h2>{{ $totalPendaftar }}</h2></div>
                    <div class="stat-icon" style="color: #ffc107;">📝</div>
                </div>

                <div class="stat-card border-green">
                    <div class="stat-info"><h4>Diverifikasi</h4><h2>{{ $totalDiverifikasi }}</h2></div>
                    <div class="stat-icon" style="color: #198754;">🔍</div>
                </div>

                <div class="stat-card border-red">
                    <div class="stat-info"><h4>Berkas Ditolak</h4><h2>{{ $totalDitolak }}</h2></div>
                    <div class="stat-icon" style="color: #dc3545;">❌</div>
                </div>

                <div class="stat-card border-purple">
                    <div class="stat-info"><h4>Lulus Seleksi</h4><h2>{{ $totalKelulusan }}</h2></div>
                    <div class="stat-icon" style="color: #6f42c1;">🎓</div>
                </div>
            </div>

            <div class="content-grid">
                
                <div class="card">
                    <h3 class="card-title">Grafik Pendaftar Baru (7 Hari Terakhir)</h3>
                    <canvas id="grafikPendaftar" height="100"></canvas>
                </div>

                <div class="card">
                    <h3 class="card-title">Informasi SPMB</h3>
                    
                    <ul class="info-list">
                        <li>
                            <span>Status Pendaftaran:</span>
                            @if($statusPendaftaran == 'buka')
                                <span class="badge badge-success">DIBUKA</span>
                            @else
                                <span class="badge badge-danger">DITUTUP</span>
                            @endif
                        </li>
                        <li><span>Tahun Ajaran:</span><strong>2026/2027</strong></li>
                        <li><span>Total Pendaftar:</span><strong>{{ $totalPendaftar }} Siswa</strong></li>
                        <li>
                            <span>Pendaftar Hari Ini:</span>
                            <strong>+{{ collect($dataPendaftar)->last() }} Orang</strong>
                        </li>
                    </ul>

                    <form action="{{ route('admin.toggle_pendaftaran') }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        @if($statusPendaftaran == 'buka')
                            <input type="hidden" name="status" value="tutup">
                            <button type="submit" class="btn-toggle" style="background-color: #dc3545; color: white;">
                                Tutup Pendaftaran Siswa Baru
                            </button>
                        @else
                            <input type="hidden" name="status" value="buka">
                            <button type="submit" class="btn-toggle" style="background-color: #198754; color: white;">
                                Buka Pendaftaran Siswa Baru
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('grafikPendaftar').getContext('2d');
        
        // Mem-parsing data PHP ke format JSON yang dimengerti JavaScript
        const labelHari = {!! json_encode($labels) !!};
        const dataJumlah = {!! json_encode($dataPendaftar) !!};

        const grafikPendaftar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelHari, // Variabel dari Laravel (Hari)
                datasets: [{
                    label: 'Jumlah Pendaftar Baru',
                    data: dataJumlah, // Variabel dari Laravel (Jumlah Pendaftar)
                    backgroundColor: 'rgba(220, 53, 69, 0.8)', 
                    borderColor: '#dc3545',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Agar sumbu Y selalu angka bulat
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>