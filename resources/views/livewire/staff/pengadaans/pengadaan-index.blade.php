<div>
    @section('title', 'List Pengadaan')

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

            <div class="table-responsive">
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
                                <th>Aksi</th>
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
                                    <td>
                                        <div class="d-flex gap-1">

                                            {{-- Tombol Upload Bukti --}}
                                            @if($pengadaan->status === 'disetujui')
                                                <button wire:click="$set('showUploadModal', {{ $pengadaan->id }})"
                                                        class="btn btn-success btn-sm">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            @endif

                                            {{-- Tombol Show Detail --}}
                                            <a href="{{ route('staff.pengadaans.show', $pengadaan->id) }}"
                                            class="btn btn-info btn-sm" title="Lihat Detail" wire:navigate>
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <button wire:click="deletePengadaan({{ $pengadaan->id }})"
                                                    class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
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
        </div>
    </section>

    {{-- Modal Upload Bukti --}}
    @foreach($pengadaans as $pengadaan)
        @if($showUploadModal === $pengadaan->id)
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="bg-white p-4 rounded shadow" style="width: 400px;">
                    <h5 class="mb-3">Upload Bukti Pengadaan</h5>

                    <input type="file" wire:model="bukti.{{ $pengadaan->id }}" class="form-control mb-3">

                    <div class="d-flex justify-content-between">
                        <button wire:click="uploadBukti({{ $pengadaan->id }})" class="btn btn-primary">
                            Kirim Bukti
                        </button>
                        <button wire:click="$set('showUploadModal', 0)" class="btn btn-secondary">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }
    </style>
</div>
<script>
    // Untuk Livewire v3
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('bukti-uploaded', (event) => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: event.message,
                timer: 1500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                // Redirect ke halaman list pengadaan
                // window.location.href ="{{ route('staff.pengadaans.index') }}";
            });
        });
    });
</script>

