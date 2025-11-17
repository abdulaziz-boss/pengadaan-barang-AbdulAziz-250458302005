<div>
    @section('title', 'Daftar Pengajuan Barang')

    <div>
        <section class="section">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Pengajuan Barang</h5>

                    <div class="input-group w-50">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input
                            type="text"
                            wire:model.live="search"
                            class="form-control"
                            placeholder="Cari kode atau status pengajuan..."
                        >
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped align-middle">
                        <thead class="bg-primary">
                            <tr>
                                <th>Kode Pengadaan</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Disetujui</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengadaans as $pengadaan)
                                <tr>
                                    <td>{{ $pengadaan->kode_pengadaan }}</td>
                                    <td>Rp {{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @switch($pengadaan->status)
                                            @case('diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                                @break
                                            @case('disetujui')
                                                <span class="badge bg-success">Disetujui</span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @case('selesai')
                                                <span class="badge bg-primary">Selesai</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $pengadaan->tanggal_pengajuan ?? '-' }}</td>
                                    <td>{{ $pengadaan->tanggal_disetujui ?? '-' }}</td>
                                    <td>{{ $pengadaan->tanggal_selesai ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada data pengajuan ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $pengadaans->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
