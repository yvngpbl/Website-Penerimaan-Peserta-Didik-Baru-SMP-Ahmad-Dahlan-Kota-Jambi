<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pendaftaran - Admin</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f7f6; 
            padding: 30px; 
            color: #333;
            margin: 0;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        h2 { margin: 0; font-size: 24px; color: #333; }
        
        .btn-back { 
            color: #dc3545; 
            text-decoration: none; 
            font-weight: 600; 
            font-size: 14px;
        }
        .btn-back:hover { text-decoration: underline; }

        /* --- STATISTIK BOX --- */
        .stats-wrapper { 
            display: flex; 
            gap: 20px; 
            margin-bottom: 25px; 
        }
        .stat-box { 
            background: white; 
            padding: 20px 25px; 
            border-radius: 8px; 
            flex: 1; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border-left: 5px solid #dc3545; /* Aksen garis merah di kiri */
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .stat-title { font-size: 14px; font-weight: bold; color: #333; }
        .stat-value { font-size: 26px; font-weight: bold; color: #000; }

        /* --- PANEL KONTROL --- */
        .kontrol-panel { 
            background: white; 
            padding: 20px 25px; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); 
            margin-bottom: 25px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .btn-toggle-tutup { background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 13px; transition: 0.3s; }
        .btn-toggle-tutup:hover { background: #c82333; }
        .btn-toggle-buka { background: #198754; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 13px; transition: 0.3s; }
        .btn-toggle-buka:hover { background: #157347; }

        /* --- WRAPPER TABEL & PENCARIAN --- */
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            overflow: hidden;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
        }
        .table-header h3 { margin: 0; font-size: 16px; color: #333; }
        
        .search-box input { 
            padding: 10px 15px; 
            width: 280px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-size: 13px;
            outline: none;
            transition: border 0.3s;
        }
        .search-box input:focus { border-color: #dc3545; }

        /* --- STYLE TABEL --- */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px 25px; text-align: left; }
        th { 
            background: #f8f9fa; /* Abu-abu muda persis seperti referensi */
            color: #333; 
            font-size: 12px; 
            text-transform: uppercase;
            font-weight: 700;
        }
        td { 
            border-bottom: 1px solid #f1f1f1; 
            font-size: 14px;
            color: #444;
        }
        tr:last-child td { border-bottom: none; }

        /* --- BADGES --- */
        .badge-kuning { background: #ffc107; color: #000; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
        .badge-hijau { background: #198754; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
        .badge-merah { background: #dc3545; color: white; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
        
        /* --- BUTTON AKSI --- */
        .btn-detail { 
            background: #dc3545; 
            text-decoration: none; 
            padding: 8px 16px; 
            border-radius: 6px; 
            color: white; 
            font-size: 12px; 
            font-weight: bold; 
            display: inline-block; 
            transition: background 0.3s;
        }
        .btn-detail:hover { background: #c82333; }
        
        .text-muted { color: #888; font-style: italic; font-size: 13px; }
        .alert-success { background: #d4edda; color: #155724; padding: 15px 25px; margin-bottom: 20px; border-radius: 8px; font-size: 14px; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <div class="page-header">
        <h2>Data Pendaftar SPMB</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">&lt; Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Ringkasan Statistik --}}
    <div class="stats-wrapper">
        <div class="stat-box">
            <span class="stat-title">Total Pendaftar</span>
            <span class="stat-value">{{ $pendaftarans->count() }}</span>
        </div>
        <div class="stat-box">
            <span class="stat-title">Belum Verif</span>
            <span class="stat-value">{{ $pendaftarans->where('status_verifikasi', 'belum_diperiksa')->count() }}</span>
        </div>
        <div class="stat-box">
            <span class="stat-title">Diverifikasi</span>
            <span class="stat-value">{{ $pendaftarans->where('status_verifikasi', 'berhasil')->count() }}</span>
        </div>
    </div>

    @php
        $statusPendaftaran = (new \App\Models\Pengaturan)->setTable('pengaturan')->where('nama_pengaturan', 'status_pendaftaran')->value('nilai') ?? 'buka';
    @endphp

    <div class="kontrol-panel">
        <div>
            <h4 style="margin: 0 0 5px 0; color: #333;">Kontrol Akses Pendaftaran</h4>
            <span style="font-size: 13px; color: #666;">Status Saat Ini: <strong style="color: #000;">{{ strtoupper($statusPendaftaran) }}</strong></span>
        </div>
        <form action="{{ route('admin.toggle_pendaftaran') }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="{{ $statusPendaftaran == 'buka' ? 'tutup' : 'buka' }}">
            <button type="submit" class="{{ $statusPendaftaran == 'buka' ? 'btn-toggle-tutup' : 'btn-toggle-buka' }}">
                {{ $statusPendaftaran == 'buka' ? 'TUTUP PENDAFTARAN' : 'BUKA PENDAFTARAN' }}
            </button>
        </form>
    </div>

    {{-- Wrapper Tabel & Search Bar --}}
    <div class="table-container">
        <div class="table-header">
            <h3>Manajemen Pendaftar</h3>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari berdasarkan nama atau NISN..." onkeyup="searchTable()">
            </div>
        </div>
        
        <table id="pendaftarTable">
            <thead>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>NISN</th>
                    <th>Status Saat Ini</th>
                    <th>Catatan Admin</th>
                    <th>Aksi</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($pendaftarans as $data)
                <tr>
                    <td style="font-weight: bold;">{{ $data->user->biodata->nama_lengkap ?? 'Belum isi biodata' }}</td>
                    <td>{{ $data->user->biodata->nisn ?? '-' }}</td>
                    <td>
                       @if($data->status_verifikasi == 'belum_diperiksa')
                            <span class="badge-kuning">Belum Diperiksa</span>
                        @elseif($data->status_verifikasi == 'berhasil') 
                            <span class="badge-hijau">Lulus Verifikasi</span>
                        @else
                            <span class="badge-merah">Tidak Lulus</span>
                        @endif
                    </td>
                    <td>
                        @if($data->catatan_verifikasi)
                            <span class="text-muted">"{{ $data->catatan_verifikasi }}"</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pendaftar.detail', $data->id) }}" class="btn-detail">Lihat Detail Berkas</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let table = document.getElementById("pendaftarTable");
            let tr = table.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                let name = tr[i].getElementsByTagName("td")[0].textContent.toLowerCase();
                let nisn = tr[i].getElementsByTagName("td")[1].textContent.toLowerCase();
                if (name.includes(input) || nisn.includes(input)) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    </script>

</body>
</html>