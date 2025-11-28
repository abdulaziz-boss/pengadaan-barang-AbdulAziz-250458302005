<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|min:6',
    ];

    protected $messages = [
        'name.required' => 'Username wajib diisi.',

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',

        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Password dan Konfirmasi Password tidak sama.',

        'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
        'password_confirmation.min' => 'Konfirmasi Password minimal 6 karakter.',
    ];

    public function register()
    {
        $this->validate();

        // Buat user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'staff',
        ]);

        // Redirect ke login
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
