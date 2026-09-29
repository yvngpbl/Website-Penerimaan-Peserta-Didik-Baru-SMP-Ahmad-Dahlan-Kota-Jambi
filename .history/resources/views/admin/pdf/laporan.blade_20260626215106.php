<style>
    table { width: 100%; border-collapse: collapse; font-family: sans-serif; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
    th { background-color: #f2f2f2; }
</style>
<h2>Laporan Data Pendaftar SPMB</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>Sekolah</th>
            <th>Tanggal Daftar</th>
            <th>Jalur</th>
            <th>Status Verif</th>
            <th>Status Lulus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pendaftarans as $i => $pd)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $pd->user->biodata->nama_lengkap ?? '-' }}</td>
            <td>{{ $pd->user->biodata->nisn ?? '-' }}</td>
            <td>{{ $pd->user->biodata->asal_sekolah ?? '-' }}</td>
            <td>{{ $pd->created_at->format('d/m/Y') }}</td>
            <td>{{ $pd->kriteria }}</td>
            <td>{{ $pd->status_verifikasi }}</td>
            <td>{{ $pd->status_lulus ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>