<div>
    <section class="section">
        <div class="row">
            {{-- Kolom kiri - Avatar --}}
            <div class="col-12 col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="mx-auto mb-3" style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%;">
                            <img src="{{ $avatar }}" alt="Avatar" class="w-100 h-100 object-fit-cover border">
                        </div>

                        <h4 class="fw-bold">{{ $name }}</h4>
                        <p class="text-muted text-capitalize">{{ $role }}</p>

                        <a href="{{ route('staff.profile.edit') }}" class="btn btn-primary mt-2" wire:navigate>
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>

                    </div>
                </div>
            </div>

            {{-- Kolom kanan - Info Profil --}}
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Informasi Akun</h5>

                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama Lengkap</th>
                                <td>{{ $name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ ucfirst($role) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
