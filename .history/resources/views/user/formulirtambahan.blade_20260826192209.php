
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Tambahan - SMP Ahmad Dahlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 15px; }
        canvas { cursor: crosshair; touch-action: none; border: 2px dashed #ccc !important; max-width: 100%; }
        .peraturan-text { font-size: 0.9rem; text-align: justify; height: 350px; overflow-y: scroll; padding: 20px; background: #fff; border: 1px solid #dee2e6; border-radius: 8px; }
        .section-title { border-left: 4px solid #198754; padding-left: 10px; font-weight: bold; color: #198754; margin-top: 20px; margin-bottom: 15px; }
        .canvas-container { position: relative; width: 100%; max-width: 350px; margin: 0 auto; }

        /* =======================================================
        PENYEMPURNAAN MOBILE FRIENDLY (Maksimal Layar 768px)
           ======================================================= */
        @media (max-width: 768px) {
            /* Menyesuaikan jarak padding agar tidak terlalu mepet atau terlalu lebar di HP */
            .container { padding-top: 20px !important; padding-bottom: 20px !important; }
            .card-body { padding: 15px !important; }
            
            /* Menyesuaikan ukuran teks judul */
            .card-header h4 { font-size: 18px; }
            .section-title { font-size: 16px; margin-top: 15px; }

            /* Mencegah alert sukses bertabrakan dengan tombol PDF */
            .alert-success {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .alert-success a { width: 100%; }

            /* Menyesuaikan kotak peraturan agar tidak terlalu panjang di layar kecil */
            .peraturan-text {
                height: 280px; 
                padding: 15px;
                font-size: 0.85rem;
            }

            /* Memaksa kontainer tanda tangan menjadi full-width mengikuti layar HP */
            .canvas-container { max-width: 100%; }
            canvas { width: 100% !important; }
            
            /* Penyesuaian teks label dan tombol */
            .form-label { font-size: 14px; }
            .form-check-label { font-size: 14px; }
            #btn-submit-pendaftaran { font-size: 16px; padding: 12px !important; }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Tombol Download PDF (Fix Route) --}}
            @if($pendaftaran->tgl_persetujuan)
            <div class="alert alert-success shadow-sm mb-4 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"><i class="fas fa-check-circle me-2"></i> Formulir Berhasil Disimpan!</h5>
                    <p class="mb-0 small">Anda sekarang dapat mengunduh dokumen pernyataan resmi dalam format PDF.</p>
                </div>
                <a href="{{ route('user.pendaftaran') }}" class="btn btn-danger fw-bold">
                    <i class="fas fa-file-pdf me-2"></i> DOWNLOAD PDF
                </a>
            </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0">Formulir Pernyataan & Persetujuan Resmi</h4>
                    <p class="mb-0 small">SMP Ahmad Dahlan Kota Jambi Tahun Ajaran 2026/2027</p>
                </div>
                <div class="card-body p-4">

                    {{-- FITUR BARU: Menampilkan Pesan Error Validasi dari Laravel jika data ditolak Controller --}}
                    @if ($errors->any())
                        <div class="alert alert-danger shadow-sm border-0 mb-4">
                            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Gagal Menyimpan! Periksa Kembali Input Anda:</h6>
                            <ul class="mb-0 small ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger shadow-sm border-0 mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    {{-- Dihapus onsubmit-nya agar di-handle penuh oleh tombol via JavaScript --}}
                    <form action="{{ route('user.pendaftaran.store_tambahan') }}" method="POST" id="formTTD" novalidate>
                        @csrf
                        
                        {{-- DATA MANUAL SISWA & ORANG TUA --}}
                        <h5 class="section-title"><i class="fas fa-user-edit me-2"></i> DATA PERNYATAAN KEL Kelengkapan Dokumen</h5>
                        <div class="p-3 bg-light rounded border mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tempat, Tanggal Lahir Siswa</label>
                                    <input type="text" name="ttl_manual" class="form-control" value="{{ old('ttl_manual', $biodata->tempat_lahir . ', ' . \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d-m-Y')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">NISN</label>
                                    <input type="text" name="nisn" class="form-control" value="{{ old('nisn', $biodata->nisn ?? '') }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Alamat Lengkap</label>
                                    <textarea name="alamat_manual" class="form-control" rows="2" required>{{ old('alamat_manual', $biodata->alamat) }}</textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">TTL Ayah</label>
                                    <input type="text" name="ttl_ayah" class="form-control" placeholder="Contoh: Jambi, 01-01-1980" value="{{ old('ttl_ayah') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">No HP Ayah</label>
                                    <input type="text" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah', $biodata->no_hp_ayah ?? '') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold">TTL Ibu</label>
                                    <input type="text" name="ttl_ibu" class="form-control" placeholder="Contoh: Jambi, 05-05-1983" value="{{ old('ttl_ibu') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">No HP Ibu</label>
                                    <input type="text" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu', $biodata->no_hp_ibu ?? '') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- BACAAN PERATURAN SEKOLAH --}}
                        <h5 class="section-title"><i class="fas fa-file-alt me-2"></i> PERATURAN SISWA/I & KETENTUAN BIAYA</h5>
                        <div class="peraturan-text mb-4 shadow-sm">
                            <h6 class="text-center fw-bold mb-3">PERATURAN SISWA/I SMP AHMAD DAHLAN KOTA JAMBI<br>TAHUN 2026</h6>
                            
                            <strong>I. WAKTU SEKOLAH</strong>
                            <ol>
                                <li>Siswa/i sudah hadir di sekolah pukul 06.50 WIB.</li>
                                <li>Waktu belajar hari Senin s.d Jum'at pukul 07.00 s.d 15.40 WIB, kecuali 3 bulan pertama setiap hari Senin s.d Rabu pulang pukul 16.40 WIB (kegiatan matrikulasi).</li>
                                <li>Hari Sabtu pukul 07.00 s.d 11.30 WIB kecuali hari Sabtu Saturday off siswa libur.</li>
                                <li>Upacara Bendera setiap hari Senin di mulai pukul 07.00 WIB.</li>
                                <li>Senam kesegaran jasmani (SKJ) (hari Sabtu) pukul 07.00 WIB, jalan santai keluar lingkungan sekolah satu kali sebulan.</li>
                            </ol>

                            <strong>II. ATURAN SEKOLAH</strong>
                            <ol>
                                <li>Kegiatan belajar mengajar harus berlangsung dengan tertib.</li>
                                <li>Siswa yang terlambat kesekolah tidak diperkenankan masuk tanpa izin dari guru piket atau Kepala Sekolah.</li>
                                <li>Siswa yang terlambat sebanyak 3 (tiga) kali maka akan di panggil orang tua untuk diminta penjelasan nya.</li>
                                <li>Siswa yang berhalangan hadir karena izin/sakit, harus membawa surat izin dari orang tua/menelpon guru /wali kelas.</li>
                                <li>Siswa yang tidak hadir tanpa surat keterangan dianggap alpa.</li>
                                <li>Siswa yang telah berada di sekolah tidak diperkenankan keluar dari lingkungan sekolah tanpa izin dari guru piket atau Kepala Sekolah.</li>
                                <li>Siswa yang tidak hadir kesekolah 3 (tiga) hari berturut-turut tanpa keterangan, maka orang tua siswa tersebut akan dipanggil untuk dimintai keterangan.</li>
                                <li>Orang tua/wali siswa yang dipanggil 3 (tiga) kali berturut-turut, namun tidak datang maka anak tersebut akan dikembalikan kepada orang tuanya (diskor) sampai orang tua hadir kesekolah.</li>
                                <li>Setiap siswa wajib menjaga kebersihan, keamanan, ketertiban, keindahan lingkungan sekolah.</li>
                                <li>Setiap siswa wajib menyetor hafalan sebelum pelaksanaan ujian sebagai salah satu syarat untuk mengikuti ujian (baik ujian tengah semester maupun ujian semester).</li>
                            </ol>

                            <strong>III. PAKAIAN SEKOLAH</strong>
                            <ol>
                                <li>Hari Senin dan Selasa memakai pakaian putih biru, dasi, ikat pinggang, <strong>sepatu hitam polos (tali sepatu dan lis warna hitam)</strong>, kaos kaki putih serta topi SMP Ahmad Dahlan.</li>
                                <li>Hari Rabu memakai pakaian Pramuka (sesuai instruksi walikota), sepatu hitam dan kaos kaki hitam.</li>
                                <li>Hari Kamis memakai pakaian Batik dan bawahan putih, sepatu hitam dan kaos kaki putih.</li>
                                <li>Hari Jum'at memakai pakaian muslim, sepatu dan kaos kaki hitam.</li>
                                <li>Hari Sabtu memakai pakaian Hizbul Wathon dan membawa pakaian Tapak Suci.</li>
                                <li>Pakaian Olahraga hanya dipakai pada saat jam pelajaran olahraga.</li>
                                <li>Bagi siswa perempuan jilbab wajib dipakai sesuai ketentuan dari sekolah yaitu untuk pakaian hari Senin, Jum'at dan Sabtu (Hizbul Wathon), sedangkan jilbab untuk pakaian batik (warna biru dongker), pramuka (warna coklat) dan tapak suci (warna hitam) diperbolehkan memakai jilbab sorong (beli sendiri).</li>
                            </ol>

                            <strong>IV. ETIKA / SOPAN SANTUN</strong>
                            <ol>
                                <li>Siswa wajib memberi salam kepada guru baik di dalam maupun di luar lingkungan sekolah.</li>
                                <li>Siswa wajib menjaga kehormatan diri sendiri, nama baik keluarga maupun sekolah.</li>
                                <li>Siswa wajib berpakaian sopan sesuai syariat agama baik ketika disekolah maupun di luar lingkungan sekolah.</li>
                                <li>Siswa wajib menghormati dan mematuhi perintah guru dan karyawan serta orang yang lebih tua.</li>
                                <li>Siswa wajib melaksanakan ibadah sesuai tuntunan agama, tidak boleh saling menyakiti dan berlaku bijaksana serta peduli terhadap lingkungan.</li>
                                <li>Siswa wajib berkata-kata dengan sopan dan lemah lembut.</li>
                            </ol>

                            <hr>
                            <h6 class="text-center fw-bold mb-3">PERSETUJUAN PEMBAYARAN BIAYA MASUK SISWA/I</h6>
                            <strong>KETENTUAN BIAYA:</strong>
                            <ol>
                                <li>Bersedia melunasi biaya masuk dalam jangka waktu paling lama 3 bulan terhitung sejak awal mendaftar di SMP Ahmad Dahlan Kota Jambi.</li>
                                <li>Bersedia membayar SPP sebesar Rp. 450.000 dibayar paling lambat tanggal 10 dalam setiap bulannya.</li>
                            </ol>
                            <p class="small text-muted mt-2">Dengan mengklik setuju dan membubuhkan tanda tangan dibawah ini, Anda selaku orang tua/wali dan siswa menyatakan bersedia, tunduk, patuh, dan tidak akan mempermasalahkan besaran biaya serta aturan yang berlaku.</p>
                        </div>

                        {{-- CHECKBOX & TANDA TANGAN DIGITAL --}}
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded mb-3 bg-white">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="setuju_biaya" value="1" {{ old('setuju_biaya') ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-bold">Saya Menyetujui Ketentuan Biaya Masuk & SPP Rp 450.000/bulan</label>
                                </div>
                                <div class="text-center">
                                    <label class="form-label d-block fw-bold small">Tanda Tangan Orang Tua/Wali (Atas Meterai Elektrik)</label>
                                    <div class="canvas-container mb-2">
                                        <canvas id="pad-ortu" class="border bg-white" width="350" height="180"></canvas>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="padOrtu.clear()">Bersihkan TTD</button>
                                    </div>
                                    <textarea name="ttd_orang_tua" id="txt-ortu" class="d-none"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check p-3 border rounded mb-3 bg-white">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="setuju_peraturan" value="1" {{ old('setuju_peraturan') ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-bold">Saya Bersedia Mengikuti Seluruh Peraturan SMP Ahmad Dahlan</label>
                                </div>
                                <div class="text-center">
                                    <label class="form-label d-block fw-bold small">Tanda Tangan Siswa/i</label>
                                    <div class="canvas-container mb-2">
                                        <canvas id="pad-siswa" class="border bg-white" width="350" height="180"></canvas>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="padSiswa.clear()">Bersihkan TTD</button>
                                    </div>
                                    <textarea name="ttd_siswa" id="txt-siswa" class="d-none"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Mengubah type="submit" menjadi type="button" dengan ID khusus untuk kontrol penuh JS --}}
                        <button type="button" id="btn-submit-pendaftaran" class="btn btn-success btn-lg w-100 mt-5 py-3 fw-bold shadow">
                            <i class="fas fa-paper-plane me-2"></i> SIMPAN DAN SELESAIKAN PENDAFTARAN
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-4 small">Sistem Informasi Pendaftaran © 2026 SMP Ahmad Dahlan Kota Jambi.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvasOrtu = document.getElementById('pad-ortu');
    const canvasSiswa = document.getElementById('pad-siswa');
    
    // Set opsi background putih agar konversi ke JPEG tidak menjadi hitam background-nya
    const padOrtu = new SignaturePad(canvasOrtu, { backgroundColor: 'rgb(255, 255, 255)' });
    const padSiswa = new SignaturePad(canvasSiswa, { backgroundColor: 'rgb(255, 255, 255)' });
    
    function fitCanvas() {
        [canvasOrtu, canvasSiswa].forEach(canvas => {
            const containerWidth = canvas.parentElement.offsetWidth;
            if (containerWidth > 0 && canvas.width !== containerWidth) {
                canvas.width = containerWidth;
                canvas.height = 180;
                canvas.getContext("2d").scale(1, 1);
            }
        });
    }
    window.addEventListener("resize", fitCanvas);
    fitCanvas();

    document.getElementById('btn-submit-pendaftaran').addEventListener('click', function() {
        const form = document.getElementById('formTTD');

        // 1. Validasi Input Kolom Teks Kosong
        const inputs = [
            { name: 'ttl_manual', label: 'Tempat, Tanggal Lahir Siswa' },
            { name: 'nisn', label: 'NISN' },
            { name: 'alamat_manual', label: 'Alamat Lengkap' },
            { name: 'ttl_ayah', label: 'TTL Ayah' },
            { name: 'pekerjaan_ayah', label: 'Pekerjaan Ayah' },
            { name: 'no_hp_ayah', label: 'No HP Ayah' },
            { name: 'ttl_ibu', label: 'TTL Ibu' },
            { name: 'pekerjaan_ibu', label: 'Pekerjaan Ibu' },
            { name: 'no_hp_ibu', label: 'No HP Ibu' }
        ];

        for (let i = 0; i < inputs.length; i++) {
            const field = document.getElementsByName(inputs[i].name)[0];
            if (!field || field.value.trim() === "") {
                alert("⚠️ DATA BELUM LENGKAP:\nKolom [" + inputs[i].label + "] wajib diisi.");
                if(field) {
                    field.focus();
                    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }
        }

        // 2. Validasi Checkbox
        const cbBiaya = document.getElementsByName('setuju_biaya')[0];
        const cbPeraturan = document.getElementsByName('setuju_peraturan')[0];
        if (!cbBiaya.checked || !cbPeraturan.checked) {
            alert("⚠️ CENTANG PERSETUJUAN:\nAnda wajib mencentang kedua kotak persetujuan Biaya & Peraturan.");
            return false;
        }

        // 3. Validasi Tanda Tangan
        if (padOrtu.isEmpty() || padSiswa.isEmpty()) {
            alert("⚠️ TANDA TANGAN KOSONG:\nHarap bubuhkan tanda tangan Orang Tua dan Siswa terlebih dahulu.");
            return false;
        }

        // 4. Proses Eksekusi & Penggabungan Data ke no_hp_ortu
        try {
            // Ambil nilai dari input HP Ayah dan Ibu
            const hpAyah = document.getElementsByName('no_hp_ayah')[0].value;
            const hpIbu = document.getElementsByName('no_hp_ibu')[0].value;
            
            // Gabungkan nomornya (misal: "Ayah: 0812... / Ibu: 0852...")
            const gabungNoHp = "Ayah: " + hpAyah + " / Ibu: " + hpIbu;

            // Buat elemen input hidden baru bernama 'no_hp_ortu' secara dinamis agar dibaca oleh Controller Anda
            let hiddenInputHp = document.querySelector('input[name="no_hp_ortu"]');
            if (!hiddenInputHp) {
                hiddenInputHp = document.createElement('input');
                hiddenInputHp.type = 'hidden';
                hiddenInputHp.name = 'no_hp_ortu';
                form.appendChild(hiddenInputHp);
            }
            hiddenInputHp.value = gabungNoHp;

            // Konversi gambar TTD ke JPEG Kualitas 0.6 (Anti Overload Server)
            document.getElementById('txt-ortu').value = padOrtu.toDataURL('image/jpeg', 0.6);
            document.getElementById('txt-siswa').value = padSiswa.toDataURL('image/jpeg', 0.6);
            
            // Kirim form ke backend
            form.submit();
        } catch (err) {
            alert("Terjadi kendala sistem: " + err.message);
        }
    });
</script>
</body>
</html>