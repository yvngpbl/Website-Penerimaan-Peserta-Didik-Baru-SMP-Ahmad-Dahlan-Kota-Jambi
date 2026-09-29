<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPMB - Panel Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fc; margin: 0; color: #333;}
        
        .sidebar { width: 250px; background-color: #df3846; color: white; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { background-color: #c92332; padding: 18px 20px; font-size: 18px; font-weight: bold; color: white; }
        .sidebar a { display: block; color: white; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.1); font-size: 15px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255, 255, 255, 0.2); }

        .main-content { margin-left: 250px; min-height: 100vh; }
        .topbar { background-color: white; padding: 12px 30px; display: flex; justify-content: flex-end; align-items: center; border-bottom: 1px solid #eee; box-shadow: 0 2px 4px rgba(0,0,0,0.02);}
        .btn-logout { background-color: #c92332; color: white; border: none; padding: 6px 15px; border-radius: 4px; font-size: 13px; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background-color: #a71d2a; }
        
        .content-area { padding: 30px; }
        
        .card { border-radius: 8px; border: 1px solid #e3e6f0; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); margin-bottom: 24px; }
        
        .stat-box { border: 1px solid #e3e6f0; border-radius: 8px; padding: 15px; display: flex; align-items: center; gap: 15px; background: white;}
        .stat-icon { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; flex-shrink: 0;}
        
        .table-custom th { background-color: #f8f9fc; color: #555; font-size: 12px; font-weight: bold; text-align: center; vertical-align: middle; padding: 12px; border-bottom: 2px solid #e3e6f0;}
        .table-custom td { font-size: 12px; vertical-align: middle; text-align: center; padding: 12px;}
        
        .pagination .page-item.active .page-link { background-color: #df3846; border-color: #df3846; }
        .pagination .page-link { color: #df3846; }

        .chart-wrapper {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        .btn-outline-theme {
            color: #df3846;
            border-color: #df3846;
        }
        .btn-outline-theme:hover, .btn-outline-theme.active {
            color: #fff;
            background-color: #df3846;
            border-color: #df3846;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">Panel Admin SPMB</div>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.akun') }}">Akun Pendaftar</a>
        <a href="{{ route('admin.pendaftaran') }}">Pendaftaran</a>
        <a href="{{ route('admin.kelulusan') }}">Kelulusan</a>
        <a href="{{ route('admin.laporan') }}" class="active">Laporan</a>
        <div style="position: absolute; bottom: 20px; width: 100%;">
            <a href="{{ url('/') }}" style="border: none; font-size: 13px;"><i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt me-1"></i> Logout</button>
            </form>
        </div>

        <div class="content-area">
            <div class="mb-4">
                <h4 class="mb-0 fw-bold" style="color: #333;">Laporan SPMB</h4>
                <small class="text-muted">Dashboard &gt; Laporan</small>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="font-size: 14px;">Filter Laporan</h6>
                    <form action="{{ route('admin.laporan') }}" method="GET" class="row g-2 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight:bold;">Tahun Ajaran</label>
                            <select name="tahun_ajaran" class="form-select form-select-sm" style="font-size: 12px;">
                                <option value="2026/2027">2026/2027</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight:bold;">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm" style="font-size: 12px;">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight:bold;">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm" style="font-size: 12px;">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight:bold;">Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-select form-select-sm" style="font-size: 12px;">
                                <option value="Semua" {{ request('status_verifikasi') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                <option value="berhasil" {{ request('status_verifikasi') == 'berhasil' ? 'selected' : '' }}>Diverifikasi</option>
                                <option value="ditolak" {{ request('status_verifikasi') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="belum_diperiksa" {{ request('status_verifikasi') == 'belum_diperiksa' ? 'selected' : '' }}>Belum Diverifikasi</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight:bold;">Status Kelulusan</label>
                            <select name="status_kelulusan" class="form-select form-select-sm" style="font-size: 12px;">
                                <option value="Semua" {{ request('status_kelulusan') == 'Semua' ? 'selected' : '' }}>Semua</option>
                                <option value="lulus" {{ request('status_kelulusan') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="tidak_lulus" {{ request('status_kelulusan') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                                <option value="menunggu" {{ request('status_kelulusan') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end d-flex gap-2">
                            @if(request()->anyFilled(['tanggal_awal', 'tanggal_akhir', 'status_verifikasi', 'status_kelulusan']))
                                <a href="{{ route('admin.laporan') }}" class="btn btn-secondary btn-sm w-100 fw-bold">Reset</a>
                            @endif
                            <button type="submit" class="btn btn-danger btn-sm fw-bold w-100" style="background-color: #c92332;"><i class="fas fa-search me-1"></i> Tampilkan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col">
                    <div class="stat-box">
                        <div class="stat-icon" style="background-color: #4e73df;"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="text-muted fw-bold" style="font-size: 10px;">TOTAL PENDAFTAR</div>
                            <div class="fw-bold fs-4 lh-1 text-dark">{{ $totalPendaftar }}</div>
                            <div class="text-muted" style="font-size: 11px;">Siswa</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-box">
                        <div class="stat-icon" style="background-color: #1cc88a;"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="text-muted fw-bold" style="font-size: 10px;">DIVERIFIKASI</div>
                            <div class="fw-bold fs-4 lh-1 text-dark">{{ $diverifikasi }}</div>
                            <div class="text-muted" style="font-size: 11px;">Siswa</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-box">
                        <div class="stat-icon" style="background-color: #e74a3b;"><i class="fas fa-times-circle"></i></div>
                        <div>
                            <div class="text-muted fw-bold" style="font-size: 10px;">DITOLAK</div>
                            <div class="fw-bold fs-4 lh-1 text-dark">{{ $ditolak }}</div>
                            <div class="text-muted" style="font-size: 11px;">Siswa</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-box">
                        <div class="stat-icon" style="background-color: #6f42c1;"><i class="fas fa-graduation-cap"></i></div>
                        <div>
                            <div class="text-muted fw-bold" style="font-size: 10px;">LULUS</div>
                            <div class="fw-bold fs-4 lh-1 text-dark">{{ $lulus }}</div>
                            <div class="text-muted" style="font-size: 11px;">Siswa</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-box">
                        <div class="stat-icon" style="background-color: #f6c23e;"><i class="fas fa-user-times"></i></div>
                        <div>
                            <div class="text-muted fw-bold" style="font-size: 10px;">TIDAK LULUS</div>
                            <div class="fw-bold fs-4 lh-1 text-dark">{{ $tidakLulus }}</div>
                            <div class="text-muted" style="font-size: 11px;">Siswa</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">Grafik Pendaftar</h6>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-theme active" id="btnBulan" onclick="updateChart('bulan')">Per Bulan</button>
                                    <button type="button" class="btn btn-outline-theme" id="btnTahun" onclick="updateChart('tahun')">Per Tahun</button>
                                </div>
                            </div>
                            
                            <div class="chart-wrapper">
                                <canvas id="mainBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;">Status Verifikasi</h6>
                            <div class="chart-wrapper">
                                <canvas id="pieVerif"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;">Status Kelulusan</h6>
                            <div class="chart-wrapper">
                                <canvas id="pieLulus"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 text-dark" style="font-size: 14px;">Data Laporan Pendaftar</h6>
                    <div class="table-responsive">
                        <table class="table table-custom table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Nama Pendaftar</th>
                                    <th>NISN</th>
                                    <th>Asal Sekolah</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Jalur Pendaftaran</th>
                                    <th>Status Verifikasi</th>
                                    <th>Status Kelulusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarans as $index => $pd)
                                <tr>
                                    <td>{{ $pendaftarans->firstItem() + $index }}</td>
                                    <td class="text-start text-dark">{{ $pd->user->biodata->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $pd->user->biodata->nisn ?? '-' }}</td>
                                    <td>{{ $pd->user->biodata->asal_sekolah ?? '-' }}</td>
                                    <td>{{ $pd->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $pd->kriteria ?? '-' }}</td>
                                    <td>
                                        @if($pd->status_verifikasi == 'berhasil')
                                            <span style="color:#1cc88a; font-weight:bold; padding:2px 8px; border:1px solid #1cc88a; border-radius:4px;">Diverifikasi</span>
                                        @elseif($pd->status_verifikasi == 'ditolak')
                                            <span style="color:#e74a3b; font-weight:bold; padding:2px 8px; border:1px solid #e74a3b; border-radius:4px; background:#fceceb;">Ditolak</span>
                                        @else
                                            <span style="color:#858796; font-weight:bold;">Belum Diverifikasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pd->status_lulus == 'lulus')
                                            <span class="badge text-white rounded-1 px-3 py-1" style="background-color: #1cc88a;">Lulus</span>
                                        @elseif($pd->status_lulus == 'tidak_lulus')
                                            <span class="badge text-danger rounded-1 px-3 py-1" style="background-color: #fceceb;">Tidak Lulus</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pendaftar.detail', $pd->id) }}" class="btn btn-light btn-sm border text-muted fw-bold d-inline-flex align-items-center gap-1" style="font-size:10px;">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="9" class="text-muted py-4">Data laporan masih kosong atau tidak ada yang cocok dengan filter.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.laporan.excel') . '?' . http_build_query(request()->all()) }}" class="btn btn-outline-success btn-sm fw-bold px-3"><i class="fas fa-file-excel me-1"></i> Export Excel</a>
                            <a href="{{ route('admin.laporan.pdf') . '?' . http_build_query(request()->all()) }}" class="btn btn-outline-danger btn-sm fw-bold px-3"><i class="fas fa-file-pdf me-1"></i> Cetak PDF</a>
                            <button class="btn btn-outline-secondary btn-sm fw-bold px-3 text-dark"><i class="fas fa-print me-1"></i> Print</button>
                        </div>
                        <div>
                            {{ $pendaftarans->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        Chart.register(ChartDataLabels);

        // DATA UNTUK GRAFIK BAR
        const labelBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const dataBulan = @json($chartBulan);

        const labelTahun = {!! json_encode($labelTahun ?? ['2023', '2024', '2025', '2026', '2027']) !!};
        const dataTahun = {!! json_encode($chartTahun ?? [50, 85, 120, 250, 420]) !!};
        
        // DATA UNTUK GRAFIK PIE
        const dataVerif = @json($chartVerif);
        const dataLulus = @json($chartLulus);

        const datalabelsOptions = {
            color: '#fff',
            font: { weight: 'bold', size: 10 },
            formatter: (value, ctx) => {
                let sum = 0;
                let dataArr = ctx.chart.data.datasets[0].data;
                dataArr.map(data => { sum += data; });
                if (value == 0 || sum == 0) return '';
                let percentage = (value * 100 / sum).toFixed(1) + "%";
                return percentage;
            }
        };

        // INISIALISASI GRAFIK BAR UTAMA (DEFAULT: PER BULAN)
        const ctxBar = document.getElementById('mainBarChart');
        let myMainBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: labelBulan,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: dataBulan,
                    backgroundColor: '#4e73df',
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { boxWidth: 12 } },
                    datalabels: { display: false } 
                }
            }
        });

        // FUNGSI UNTUK UPDATE DATA GRAFIK SECARA DINAMIS
        function updateChart(type) {
            const btnBulan = document.getElementById('btnBulan');
            const btnTahun = document.getElementById('btnTahun');

            if (type === 'bulan') {
                // Aktifkan tombol Bulan
                btnBulan.classList.add('active');
                btnTahun.classList.remove('active');
                
                // Ubah data di dalam grafik menjadi data bulan
                myMainBarChart.data.labels = labelBulan;
                myMainBarChart.data.datasets[0].data = dataBulan;
                myMainBarChart.data.datasets[0].backgroundColor = '#4e73df'; // Biru
            } else {
                // Aktifkan tombol Tahun
                btnTahun.classList.add('active');
                btnBulan.classList.remove('active');
                
                // Ubah data di dalam grafik menjadi data tahun
                myMainBarChart.data.labels = labelTahun;
                myMainBarChart.data.datasets[0].data = dataTahun;
                myMainBarChart.data.datasets[0].backgroundColor = '#1cc88a'; // Hijau (agar terlihat perbedaannya)
            }
            
            // Perintahkan Chart.js untuk merender ulang datanya
            myMainBarChart.update();
        }

        // PIE CHART VERIFIKASI
        new Chart(document.getElementById('pieVerif'), {
            type: 'pie',
            data: {
                labels: [`Diverifikasi (${dataVerif[0]})`, `Ditolak (${dataVerif[1]})`, `Belum (${dataVerif[2]})`],
                datasets: [{
                    data: dataVerif,
                    backgroundColor: ['#1cc88a', '#e74a3b', '#858796'],
                    borderWidth: 1
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true, font: {size: 10} } },
                    datalabels: datalabelsOptions
                }
            }
        });

        // PIE CHART KELULUSAN
        new Chart(document.getElementById('pieLulus'), {
            type: 'pie',
            data: {
                labels: [`Lulus (${dataLulus[0]})`, `Tidak Lulus (${dataLulus[1]})`, `Menunggu (${dataLulus[2]})`],
                datasets: [{
                    data: dataLulus,
                    backgroundColor: ['#4e73df', '#f6c23e', '#858796'],
                    borderWidth: 1
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { boxWidth: 10, usePointStyle: true, font: {size: 10} } },
                    datalabels: datalabelsOptions
                }
            }
        });
    </script>
</body>
</html>