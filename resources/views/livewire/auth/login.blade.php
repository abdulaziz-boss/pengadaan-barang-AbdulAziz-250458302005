<div>
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo" style="margin-bottom: 25px; margin-top: -45px;">
                    <a href="#">
                        <img src="{{ asset('images/logo.png') }}"
                            alt="Logo"
                            style="max-width: 180px; height: auto;">
                    </a>
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                {{-- Success message (misalnya setelah register) --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error login gagal --}}
                @error('login')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <form wire:submit.prevent="login">
                    {{-- Email Input --}}
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="text" wire:model.defer="email"
                               class="form-control form-control-xl" placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>

                    {{-- Error email --}}
                    @error('email')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror

                    {{-- Password Input --}}
                    <div class="form-group position-relative has-icon-left mb-2">
                        <input type="password" wire:model.defer="password"
                               class="form-control form-control-xl" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>

                    {{-- Error password --}}
                    @error('password')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
                        Log in
                    </button>
                </form>

                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">Don't have an account?
                        <a href="{{ route('register') }}" class="font-bold">Sign up</a>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
