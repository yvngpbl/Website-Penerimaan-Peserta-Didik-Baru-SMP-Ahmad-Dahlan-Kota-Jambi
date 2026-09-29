<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kelulusan - Panel Admin SPMB</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            color: #333;
        }
        
        .sidebar {
            width: 250px;
            background-color: #df3846; 
            color: white;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .sidebar-brand {
            background-color: #c92332; 
            padding: 18px 20px;
            font-size: 18px;
            font-weight: bold;
            color: white;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 15px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2); 
        }

        .main-content { margin-left: 250px; min-height: 100vh; }
        
        .topbar {
            background-color: white;
            padding: 12px 30px;
            display: flex;
            justify-content: flex-end;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-logout:hover { background-color: #c82333; }

        .content-area { padding: 30px; }
        
        .card { border-radius: 10px; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        
        .custom-tabs { border-bottom: 2px solid #ddd; margin-bottom: 20px; display: flex; gap: 20px; }
        .custom-tab { padding-bottom: 10px; font-weight: bold; color: #888; border-bottom: 2px solid transparent; cursor: pointer; }
        .custom-tab.active { color: #dc3545; border-bottom: 2px solid #dc3545; }

        .table-custom th { font-weight: 600; color: #555; font-size: 13px; border-bottom: 1px solid #ddd; padding: 12px 10px; }
        .table-custom td { font-size: 13px; vertical-align: middle; padding: 15px 10px; border-bottom: 1px solid #eee; }
        .table-custom tbody tr:hover { background-color: #fcfcfc; }

        /* Efek hover untuk badge agar terlihat bisa diklik */
        .clickable-badge { transition: transform 0.2s; display: inline-block; }
        .clickable-badge:hover { transform: scale(1.05); cursor: pointer; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-brand">Panel Admin SPMB</div>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.akun') }}">Akun Pendaftar</a>
        <a href="{{ route('admin.pendaftaran') }}">Pendaftaran</a>
        <a href="{{ route('admin.kelulusan') }}" class="active">Kelulusan</a>
        <a href="{{ route('admin.laporan') }}">Laporan</a>
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
                <h4 class="mb-0 fw-bold">Laporan Kelulusan</h4>
                <small class="text-muted">Dashboard &gt; Kelulusan</small>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $total = $pendaftarans->count();
                $lulus = $pendaftarans->where('status_lulus', 'lulus')->count();
                $tidakLulus = $pendaftarans->where('status_lulus', 'tidak_lulus')->count();
            @endphp

            <div class="row mb-4">
                <div class="col-lg-7">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4">Ringkasan Hasil Seleksi</h6>
                            <div class="d-flex gap-3">
                                <div class="border rounded px-2 py-3 flex-fill text-center bg-white">
                                    <div class="d-flex justify-content-center mb-2">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="fas fa-users fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="text-muted fw-bold mb-1" style="font-size: 10px;">TOTAL PESERTA SELEKSI</div>
                                    <div class="fs-4 fw-bold text-dark lh-1">{{ $total }}</div>
                                    <div class="text-muted mt-1" style="font-size: 12px;">Siswa</div>
                                </div>
                                <div class="border rounded px-2 py-3 flex-fill text-center bg-white">
                                    <div class="d-flex justify-content-center mb-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="fas fa-check fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="text-muted fw-bold mb-1" style="font-size: 10px;">LULUS</div>
                                    <div class="fs-4 fw-bold text-dark lh-1">{{ $lulus }}</div>
                                    <div class="text-muted mt-1" style="font-size: 12px;">Siswa</div>
                                </div>
                                <div class="border rounded px-2 py-3 flex-fill text-center bg-white">
                                    <div class="d-flex justify-content-center mb-2">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="fas fa-times fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="text-muted fw-bold mb-1" style="font-size: 10px;">TIDAK LULUS</div>
                                    <div class="fs-4 fw-bold text-dark lh-1">{{ $tidakLulus }}</div>
                                    <div class="text-muted mt-1" style="font-size: 12px;">Siswa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-1">Pengumuman Kelulusan</h6>
                            <p class="text-muted mb-4" style="font-size: 12px;">Kelola status pengumuman hasil kelulusan yang dilihat oleh pendaftar.</p>
                            
                            <div class="border rounded p-3 d-flex justify-content-between align-items-center mb-4 bg-white">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="text-{{ $statusKelulusan == 'buka' ? 'success' : 'danger' }}">
                                        <i class="fas fa-{{ $statusKelulusan == 'buka' ? 'lock-open' : 'lock' }} fs-2"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted fw-bold" style="font-size: 10px;">PENGUMUMAN KELULUSAN</div>
                                        <div class="fw-bold fs-6 text-{{ $statusKelulusan == 'buka' ? 'success' : 'danger' }}">
                                            {{ $statusKelulusan == 'buka' ? 'DIBUKA' : 'DITUTUP' }}
                                        </div>
                                        <div class="text-muted" style="font-size: 10px;">Terbuka untuk semua pendaftar</div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="form-check form-switch d-inline-block mb-1">
                                        <input class="form-check-input" type="checkbox" {{ $statusKelulusan == 'buka' ? 'checked' : '' }} disabled style="cursor: default;">
                                        <label class="form-check-label text-dark" style="font-size: 12px;">Buka</label>
                                    </div>
                                    <form action="{{ route('admin.toggle_kelulusan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ $statusKelulusan == 'buka' ? 'tutup' : 'buka' }}">
                                        <button type="submit" class="btn btn-outline-danger fw-bold btn-sm px-2 py-1" style="font-size: 11px;">
                                            {{ $statusKelulusan == 'buka' ? 'Tutup Pengumuman' : 'Buka Pengumuman' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom-tabs">
                <div class="custom-tab active">Daftar Kelulusan</div>
                
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Daftar Siswa Lulus <span class="badge bg-success bg-opacity-10 text-success ms-2 px-2 py-1">{{ $lulus }} Siswa</span></h6>
                        <div class="input-group" style="width: 280px;">
                            <input type="text" class="form-control form-control-sm border-end-0" placeholder="Cari nama / NISN..." style="font-size: 13px; height: 32px;">
                            <span class="input-group-text bg-white border-start-0 text-muted" style="height: 32px;"><i class="fas fa-search" style="font-size: 13px;"></i></span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom align-middle text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>Asal Sekolah</th>
                                    <th>Jalur</th>
                                    <th>Status</th>
                                    <th>Notifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftarans as $index => $pd)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-start text-dark fw-bold">{{ $pd->user->biodata->nama_lengkap ?? '-' }}</td>
                                    <td class="text-dark">{{ $pd->user->biodata->nisn ?? '-' }}</td>
                                    <td class="text-dark">{{ $pd->user->biodata->asal_sekolah ?? '-' }}</td>
                                    <td class="text-dark">{{ $pd->kriteria ?? '-' }}</td>
                                    
                                    <!-- Bagian Status: Sekarang bisa diklik untuk memunculkan Modal Update -->
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateModal{{ $pd->id }}" class="text-decoration-none clickable-badge" title="Klik untuk ubah status">
                                            @if($pd->status_lulus == 'lulus')
                                                <span class="badge border border-success text-success bg-white px-3 py-1 fw-bold rounded-1" style="font-size: 11px;">Lulus</span>
                                            @elseif($pd->status_lulus == 'tidak_lulus')
                                                <span class="badge border border-danger text-danger bg-white px-3 py-1 fw-bold rounded-1" style="font-size: 11px;">Tidak Lulus</span>
                                            @else
                                                <span class="badge border border-warning text-warning bg-white px-3 py-1 fw-bold rounded-1" style="font-size: 11px;">Menunggu</span>
                                            @endif
                                        </a>

                                        <!-- MODAL UPDATE STATUS KELULUSAN (Tersembunyi) -->
                                        <div class="modal fade" id="updateModal{{ $pd->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h6 class="modal-title fw-bold">Ubah Status</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.kelulusan.update', $pd->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body text-start">
                                                            <p class="text-muted mb-2" style="font-size:12px;">Siswa: <strong>{{ $pd->user->biodata->nama_lengkap ?? '-' }}</strong></p>
                                                            <select name="status_lulus" class="form-select form-select-sm mb-3">
                                                                <option value="menunggu" {{ $pd->status_lulus == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                                <option value="lulus" {{ $pd->status_lulus == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                                                <option value="tidak_lulus" {{ $pd->status_lulus == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                                                            </select>
                                                            <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold">Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END MODAL -->
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <button class="btn btn-outline-success fw-bold d-flex align-items-center gap-1 bg-white" style="font-size: 11px; padding: 4px 10px;">
                                                <i class="fas fa-paper-plane"></i> Kirim Notifikasi
                                            </button>
                                            
                                            <a href="{{ route('admin.pendaftar.detail', $pd->id) }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center bg-white" style="font-size: 11px; padding: 4px 8px;" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data diverifikasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <p class="text-muted mb-0" style="font-size: 12px;">Menampilkan 1 - {{ count($pendaftarans) }} dari {{ count($pendaftarans) }} data</p>
                    </div>
                </div>
            </div>

            

        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>