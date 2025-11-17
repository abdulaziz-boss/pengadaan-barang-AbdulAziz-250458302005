<div>
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-journal-text me-2"></i> Log Aktivitas
            </h4>

            <div class="input-group w-auto">
                <input type="text" wire:model.live="search" class="form-control"
                    placeholder="Cari log...">
                <span class="input-group-text bg-light">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>

        <div class="card-body">
            @if ($logs->isEmpty())
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-inbox fs-1"></i>
                    <p class="mt-2">Tidak ada log aktivitas.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table bg-primary">
                            <tr>
                                <th width="50">No</th>
                                <th>Tabel</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>Waktu</th>
                                <th width="100" class="text-center">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $index => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $index }}</td>
                                    <td>{{ $log->table_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $log->action == 'create' ? 'success' : ($log->action == 'update' ? 'warning' : 'danger') }}">
                                            {{ strtoupper($log->action) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="confirmDelete({{ $log->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- SweetAlert Script --}}
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Event untuk menampilkan konfirmasi delete
            Livewire.on('show-delete-confirmation', (data) => {
                Swal.fire({
                    title: 'Yakin hapus log ini?',
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Panggil method deleteLog dengan ID
                        Livewire.dispatch('deleteConfirmed', { id: data.id });
                    }
                });
            });

            // Event untuk menampilkan notifikasi sukses
            Livewire.on('show-delete-success', () => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Log aktivitas berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    </script>
    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
