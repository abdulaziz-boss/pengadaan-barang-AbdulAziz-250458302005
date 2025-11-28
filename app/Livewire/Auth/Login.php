<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();

            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'manager' => redirect()->route('manager.dashboard'),
                'staff' => redirect()->route('staff.dashboard'),
                default => redirect()->route('login'),
            };
        }

        $this->addError('login', 'Email atau password salah.');
    }



    public function render()
    {
        return view('livewire.auth.login');
    }
}
