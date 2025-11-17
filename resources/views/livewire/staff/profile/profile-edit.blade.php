<div>
    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h4 class="fw-bold mb-3">Edit Profil</h4>

                        <form wire:submit.prevent="updateProfile">
                            <!-- Data Profil -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" wire:model="name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" wire:model="email">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ganti Foto Profil</label>
                                <input type="file" wire:model="avatar" class="form-control" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal: 2MB</small>

                                <div class="mt-2">
                                    @if ($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" class="rounded-circle me-3" width="120" height="120">
                                    @elseif(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle me-3" width="120" height="120">
                                    @else
                                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 120px; height: 120px;">
                                            <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <hr class="my-4">

                            <!-- Password (Opsional) -->
                            <h5 class="fw-bold mb-3">Ubah Password (Opsional)</h5>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" wire:model="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" wire:model="password_confirmation" placeholder="Konfirmasi password baru">
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="bi bi-save"></i> Simpan Perubahan
                                    </span>
                                    <span wire:loading>
                                        <i class="bi bi-hourglass-split"></i> Menyimpan...
                                    </span>
                                </button>
                                <a href="{{ route('staff.profile.index') }}" wire:navigate class="btn btn-secondary"wire:navigate>
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('showSweetAlert', (event) => {
            const alertData = event[0];

            if (alertData.redirectUrl) {
                Swal.fire({
                    icon: alertData.type,
                    title: alertData.title,
                    text: alertData.text,
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.href = alertData.redirectUrl;
                    }
                });
            } else {
                Swal.fire({
                    icon: alertData.type,
                    title: alertData.title,
                    text: alertData.text,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });
</script>
