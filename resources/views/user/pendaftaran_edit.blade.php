
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pendaftaran - SMP IT Ahmad Dahlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; padding-bottom: 50px; }
        .card { border-radius: 15px; border: none; }
        .card-header { background-color: #198754; color: white; border-radius: 15px 15px 0 0 !important; padding: 20px; }
        .section-title { background: #e9ecef; padding: 10px; font-weight: bold; margin: 25px 0 15px 0; border-left: 5px solid #198754; }
        .file-preview { font-size: 0.85rem; margin-top: 5px; display: block; color: #0d6efd; text-decoration: none; font-weight: bold; }

        /* =======================================================
           PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            /* Penyesuaian margin dan padding layar kecil */
            .container { padding-left: 15px; padding-right: 15px; margin-top: 1.5rem !important; }
            .card-body { padding: 15px !important; }
            .card-header h3 { font-size: 22px; }
            
            /* Penyesuaian form label agar lebih proporsional */
            .form-label { font-size: 14px; margin-bottom: 5px; margin-top: 10px; }
            .section-title { font-size: 16px; margin-top: 20px; }

            /* Memaksa canvas tanda tangan menyesuaikan lebar layar */
            canvas {
                width: 100% !important;
                height: auto;
            }

            /* Menyusun tombol Batal dan Simpan menjadi vertikal di HP */
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 12px;
            }
            .d-flex.justify-content-between .btn {
                width: 100%;
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h3 class="mb-0">Edit Formulir Pendaftaran</h3>
                    <p class="mb-0 small">Perbarui data Anda dengan teliti sebelum menyimpan</p>
                </div>
                <div class="card-body p-4">
                    
                    <form action="{{ route('user.pendaftaran.update', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="section-title">A. IDENTITAS CALON SISWA</div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ $pendaftaran->user->biodata->nama_lengkap }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jalur Pendaftaran (Kriteria)</label>
                                <select name="kriteria" id="kriteria-select" class="form-select border-primary">
                                    <option value="Umum" {{ old('kriteria', $pendaftaran->kriteria) == 'Umum' ? 'selected' : '' }}>Umum</option>
                                    <option value="Anak Guru" {{ old('kriteria', $pendaftaran->kriteria) == 'Anak Guru' ? 'selected' : '' }}>Anak Guru (SD IT AD, SMP AD)</option>
                                    <option value="Alumni" {{ old('kriteria', $pendaftaran->kriteria) == 'Alumni' ? 'selected' : '' }}>Alumni SD IT Ahmad Dahlan</option>
                                    <option value="Saudara Kandung" {{ old('kriteria', $pendaftaran->kriteria) == 'Saudara Kandung' ? 'selected' : '' }}>Punya Saudara Kandung di SD IT / SMP AD</option>
                                    <option value="Siswa Prestasi" {{ old('kriteria', $pendaftaran->kriteria) == 'Siswa Prestasi' ? 'selected' : '' }}>Siswa Prestasi</option>
                                    <option value="Siswa Yatim" {{ old('kriteria', $pendaftaran->kriteria) == 'Siswa Yatim' ? 'selected' : '' }}>Siswa Yatim</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control" value="{{ $pendaftaran->user->biodata->nisn }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" value="{{ $pendaftaran->user->biodata->nik }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="L" {{ $pendaftaran->user->biodata->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $pendaftaran->user->biodata->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ $pendaftaran->user->biodata->tempat_lahir }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $pendaftaran->user->biodata->tanggal_lahir }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2">{{ $pendaftaran->user->biodata->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control" value="{{ $pendaftaran->user->biodata->asal_sekolah }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tinggal Bersama</label>
                                <input type="text" name="tinggal_bersama" class="form-control" value="{{ $pendaftaran->user->biodata->tinggal_bersama }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Moda Transportasi</label>
                                <input type="text" name="moda_transportasi" class="form-control" value="{{ $pendaftaran->user->biodata->moda_transportasi }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Anak Ke</label>
                                <input type="number" name="anak_ke" class="form-control" value="{{ $pendaftaran->user->biodata->anak_ke }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Jumlah Saudara</label>
                                <input type="number" name="jumlah_saudara" class="form-control" value="{{ $pendaftaran->user->biodata->jumlah_saudara }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tinggi (cm)</label>
                                <input type="number" name="tinggi_badan" class="form-control" value="{{ $pendaftaran->user->biodata->tinggi_badan }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Berat (kg)</label>
                                <input type="number" name="berat_badan" class="form-control" value="{{ $pendaftaran->user->biodata->berat_badan }}">
                            </div>
                        </div>

                        <div class="section-title">B. DATA ORANG TUA</div>
                        <div class="row mb-3">
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-success text-center">DATA AYAH</h6>
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->nama_ayah }}">
                                <label class="form-label">Pendidikan Ayah</label>
                                <input type="text" name="pendidikan_ayah" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->pendidikan_ayah }}">
                                <label class="form-label">Pekerjaan Ayah</label>
                                <input type="text" name="pekerjaan_ayah" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->pekerjaan_ayah }}">
                                <label class="form-label">Penghasilan Ayah (Angka)</label>
                                <input type="number" name="penghasilan_ayah" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->penghasilan_ayah }}">
                                <label class="form-label">No. HP Ayah</label>
                                <input type="text" name="no_hp_ayah" class="form-control" value="{{ $pendaftaran->user->biodata->no_hp_ayah }}">
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success text-center">DATA IBU</h6>
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->nama_ibu }}">
                                <label class="form-label">Pendidikan Ibu</label>
                                <input type="text" name="pendidikan_ibu" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->pendidikan_ibu }}">
                                <label class="form-label">Pekerjaan Ibu</label>
                                <input type="text" name="pekerjaan_ibu" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->pekerjaan_ibu }}">
                                <label class="form-label">Penghasilan Ibu (Angka)</label>
                                <input type="number" name="penghasilan_ibu" class="form-control mb-2" value="{{ $pendaftaran->user->biodata->penghasilan_ibu }}">
                                <label class="form-label">No. HP Ibu</label>
                                <input type="text" name="no_hp_ibu" class="form-control" value="{{ $pendaftaran->user->biodata->no_hp_ibu }}">
                            </div>
                        </div>

                        <div class="section-title">C. BERKAS (Upload Ulang Jika Ingin Mengganti)</div>
                        <div class="row">
                            @php
                                $berkasEdit = [
                                    'pas_foto' => 'Pas Foto',
                                    'file_raport' => 'Scan Raport',
                                    'bukti_pembayaran' => 'Bukti Pembayaran',
                                    'file_kk' => 'Scan Kartu Keluarga',
                                    'file_akte' => 'Scan Akte Kelahiran',
                                    'file_skl' => 'Scan SKL',
                                    'file_ijazah' => 'Scan Ijazah',
                                    'ktp_ortu' => 'KTP Orang Tua',
                                    'file_keterangan_sehat' => 'Ket. Sehat',
                                    'file_keterangan_yatim' => 'Ket. Yatim/Piatu',
                                    'file_piagam' => 'Piagam Penghargaan'
                                ];
                            @endphp

                            @foreach($berkasEdit as $key => $label)
                            <div class="col-md-4 mb-3" id="berkas-{{ $key }}" 
                                @if($key == 'file_piagam') 
                                    style="display: {{ old('kriteria', $pendaftaran->kriteria) == 'Siswa Prestasi' ? 'block' : 'none' }};" 
                                @elseif($key == 'file_keterangan_yatim') 
                                    style="display: {{ old('kriteria', $pendaftaran->kriteria) == 'Siswa Yatim' ? 'block' : 'none' }};" 
                                @endif
                            >
                                <label class="form-label small fw-bold">{{ $label }}</label>
                                <input type="file" name="{{ $key }}" class="form-control form-control-sm">
                                @if($pendaftaran->$key)
                                    <a href="{{ asset('storage/'.$pendaftaran->$key) }}" target="_blank" class="file-preview">Lihat File Lama</a>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="section-title">D. PERSETUJUAN & TANDA TANGAN</div>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                {{-- CHECKBOX BARU UNTUK ORANG TUA --}}
                                <div class="form-check p-3 border rounded mb-3 bg-white shadow-sm">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="setuju_biaya" value="1" {{ $pendaftaran->setuju_biaya_masuk ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-success">
                                        Saya Menyetujui Ketentuan Biaya Masuk & SPP
                                    </label>
                                </div>

                                <label class="form-label fw-bold">Tanda Tangan Orang Tua / Wali</label>
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">Tanda Tangan Saat Ini:</small>
                                    @if($pendaftaran->ttd_ayah)
                                        <img src="{{ asset('storage/'.$pendaftaran->ttd_ayah) }}" style="max-height: 100px; display: block;" class="border p-1 bg-light rounded" alt="TTD Ortu">
                                    @else
                                        <span class="badge bg-danger">Belum ada tanda tangan</span>
                                    @endif
                                </div>
                                <div class="bg-white border rounded p-2 text-center">
                                    <canvas id="canvas-ortu" width="400" height="150" class="border rounded bg-light" style="touch-action: none; max-width: 100%;"></canvas>
                                    <input type="hidden" name="ttd_orang_tua" id="txt-ortu">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearCanvas('ortu')">Bersihkan TTD</button>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                {{-- CHECKBOX BARU UNTUK SISWA --}}
                                <div class="form-check p-3 border rounded mb-3 bg-white shadow-sm">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="setuju_peraturan" value="1" {{ $pendaftaran->setuju_peraturan_sekolah ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-success">
                                        Saya Bersedia Mengikuti Seluruh Peraturan
                                    </label>
                                </div>

                                <label class="form-label fw-bold">Tanda Tangan Siswa / i</label>
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">Tanda Tangan Saat Ini:</small>
                                    @if($pendaftaran->ttd_siswa)
                                        <img src="{{ asset('storage/'.$pendaftaran->ttd_siswa) }}" style="max-height: 100px; display: block;" class="border p-1 bg-light rounded" alt="TTD Siswa">
                                    @else
                                        <span class="badge bg-danger">Belum ada tanda tangan</span>
                                    @endif
                                </div>
                                <div class="bg-white border rounded p-2 text-center">
                                    <canvas id="canvas-siswa" width="400" height="150" class="border rounded bg-light" style="touch-action: none; max-width: 100%;"></canvas>
                                    <input type="hidden" name="ttd_siswa" id="txt-siswa">
                                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearCanvas('siswa')">Bersihkan TTD</button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.riwayat') }}" class="btn btn-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-5 fw-bold shadow">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        // --- TAMBAHAN JS UNTUK DINAMIS BERKAS ---
        const kriteriaSelect = document.getElementById('kriteria-select');
        const formPiagam = document.getElementById('berkas-file_piagam');
        const formYatim = document.getElementById('berkas-file_keterangan_yatim');

        function aturTampilanBerkas(nilaiKriteria) {
            if(formPiagam) formPiagam.style.display = 'none';
            if(formYatim) formYatim.style.display = 'none';

            // Penyesuaian pengecekan JS agar sesuai huruf besar/kecil
            if (nilaiKriteria === 'Siswa Prestasi') {
                if(formPiagam) formPiagam.style.display = 'block';
            } else if (nilaiKriteria === 'Siswa Yatim') {
                if(formYatim) formYatim.style.display = 'block';
            }
        }

        if (kriteriaSelect) {
            // Panggil sekali saat halaman dimuat
            aturTampilanBerkas(kriteriaSelect.value);
            
            // Panggil setiap kali dropdown berubah
            kriteriaSelect.addEventListener('change', function (e) {
                aturTampilanBerkas(e.target.value);
            });
        }
        // ----------------------------------------

        // --- FITUR BARU: VALIDASI UKURAN FILE MAKSIMAL 2MB ---
        const fileInputs = document.querySelectorAll('input[type="file"]');
        const maxFileSize = 2 * 1024 * 1024; // 2MB dalam bytes

        fileInputs.forEach(input => {
            input.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const fileSize = this.files[0].size;
                    
                    if (fileSize > maxFileSize) {
                        alert('Gagal! Ukuran file "' + this.files[0].name + '" terlalu besar.\n\nMaksimal ukuran yang diizinkan adalah 2MB. Silakan kompres atau pilih file lain.');
                        
                        // Kosongkan kembali input file agar tidak ikut tersubmit
                        this.value = '';
                    }
                }
            });
        });
        // -----------------------------------------------------

        const canvasOrtu = document.getElementById('canvas-ortu');
        const canvasSiswa = document.getElementById('canvas-siswa');

        const signaturePadOrtu = new SignaturePad(canvasOrtu, { 
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        const signaturePadSiswa = new SignaturePad(canvasSiswa, { 
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        function resizeCanvas() {
            [ {canvas: canvasOrtu, pad: signaturePadOrtu}, {canvas: canvasSiswa, pad: signaturePadSiswa} ].forEach(item => {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const oldData = item.pad.toData();
                
                item.canvas.width = item.canvas.offsetWidth * ratio;
                item.canvas.height = item.canvas.offsetHeight * ratio;
                item.canvas.getContext("2d").scale(ratio, ratio);
                
                item.pad.clear();
                item.pad.fromData(oldData);
            });
        }

        resizeCanvas();
        window.addEventListener("resize", resizeCanvas);

        window.clearCanvas = function(tipe) {
            if(tipe === 'ortu') signaturePadOrtu.clear();
            if(tipe === 'siswa') signaturePadSiswa.clear();
        }

        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            if (!signaturePadOrtu.isEmpty()) {
                document.getElementById('txt-ortu').value = signaturePadOrtu.toDataURL();
            }
            if (!signaturePadSiswa.isEmpty()) {
                document.getElementById('txt-siswa').value = signaturePadSiswa.toDataURL();
            }
        });
    });
</script>
</body>
</html>