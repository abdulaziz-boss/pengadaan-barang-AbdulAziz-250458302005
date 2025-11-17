<div>
    <!-- Card Utama -->
    <div class="card shadow-sm rounded-4 border-0">
        <!-- Card Header -->
        <div class="card-header  d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0">Manajemen User</h4>
            <div class="d-flex gap-2 align-items-center">
                <div class="position-relative" style="width: 300px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-white-50"></i>
                    <input
                        wire:model.live="search"
                        type="text"
                        class="form-control ps-5"
                        placeholder="Cari nama atau email..."
                    >
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm fw-semibold" wire:navigate>
                    <i class="bi bi-plus-lg"></i> Tambah User
                </a>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body rounded-bottom-4 overflow-hidden">
            <!-- Flash Message -->
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-0 mb-0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Table -->
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-primary">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{
                                    $user->role === 'admin' ? 'danger' :
                                    ($user->role === 'manager' ? 'warning text-dark' : 'success')
                                }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="badge bg-success text-decoration-none" wire:navigate>
                                    Edit
                                </a>

                                @if ($user->id != auth()->id())
                                    <button
                                        wire:click="confirmDelete({{ $user->id }})"
                                        class="badge bg-danger border-0 text-decoration-none"
                                    >
                                        Hapus
                                    </button>
                                @else
                                    <span class="badge bg-secondary">Hapus</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Tidak ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->links() }}
    </div>

    <!-- SweetAlert Script -->
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-delete-confirmation', () => {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data user ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteConfirmed');
                    }
                });
            });

            Livewire.on('user-deleted', () => {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'User berhasil dihapus.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    <style>
        thead.bg-primary th {
            color: #fff !important;
        }

    </style>
</div>
