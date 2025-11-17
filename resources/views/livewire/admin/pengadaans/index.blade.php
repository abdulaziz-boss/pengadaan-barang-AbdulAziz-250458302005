<div>
    <div class="card shadow-sm rounded-4 overflow-hidden">
        <!-- CARD HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h4 class="card-title mb-0">Data Pengadaan</h4>
            <input wire:model.live="search"
                   type="text"
                   placeholder="Cari kode pengadaan..."
                   class="form-control w-25"
                   style="max-width: 250px;">
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <table class="table align-middle mb-0">
                <thead class="bg-primary text-white" style="color: white !important;">
                    <tr>
                        <th>Kode</th>
                        <th>Pengaju</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengadaans as $p)
                        <tr>
                            <td>{{ $p->kode_pengadaan }}</td>
                            <td>{{ $p->pengaju->name ?? '-' }}</td>
                            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status == 'disetujui' ? 'success' : ($p->status == 'ditolak' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>{{ $p->tanggal_pengajuan ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pengadaans.show', $p->id) }}"
                                   class="badge bg-info text-decoration-none"
                                   wire:navigate>
                                   Detail
                                </a>
                                <button type="button"
                                        wire:click="confirmDelete({{ $p->id }})"
                                        class="badge bg-danger border-0">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">Tidak ada data pengadaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-3">
                {{ $pengadaans->links() }}
            </div>
        </div>
    </div>

    <!-- SWEETALERT SCRIPT -->
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Konfirmasi hapus
            Livewire.on('confirm-delete', (event) => {
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: 'Data yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed', { id: event.id });
                    }
                });
            });

            // Notif sukses
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil dihapus!',
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            // Notif error
            Livewire.on('swal:error', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: event.title,
                    text: event.text,
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
    @endpush

    <!-- STYLE -->
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

        .card {
            border-radius: 1rem;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid #eee;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
    </style>
</div>
