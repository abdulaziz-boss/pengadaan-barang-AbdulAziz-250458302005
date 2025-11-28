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

                <h1 class="auth-title">Sign Up</h1>
                <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                <form wire:submit.prevent="register">
                    @csrf

                    {{-- NAME --}}
                    <div class="mb-2">
                        @error('name')
                            <span class="text-danger d-block" style="font-size: 14px;">{{ $message }}</span>
                        @enderror

                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="text" wire:model="name" class="form-control form-control-xl"
                                placeholder="Name">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-2">
                        @error('email')
                            <span class="text-danger d-block" style="font-size: 14px;">{{ $message }}</span>
                        @enderror

                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="text" wire:model="email" class="form-control form-control-xl"
                                placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-2">
                        @error('password')
                            <span class="text-danger d-block" style="font-size: 14px;">{{ $message }}</span>
                        @enderror

                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" wire:model="password" class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                    </div>

                    {{-- CONFIRM PASSWORD --}}
                    <div class="mb-2">
                        @error('password_confirmation')
                            <span class="text-danger d-block" style="font-size: 14px;">{{ $message }}</span>
                        @enderror

                        <div class="form-group position-relative has-icon-left mb-3">
                            <input type="password" wire:model="password_confirmation"
                                class="form-control form-control-xl" placeholder="Confirm Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-4">
                        Sign Up
                    </button>
                </form>

                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold">Log in</a>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
