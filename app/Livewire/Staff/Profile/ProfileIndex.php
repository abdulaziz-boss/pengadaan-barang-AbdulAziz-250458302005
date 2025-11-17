<?php

namespace App\Livewire\Staff\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileIndex extends Component
{
    public $name;
    public $email;
    public $role;
    public $avatar;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->avatar = $user->avatar_url;
    }

    public function render()
    {
        return view('livewire.staff.profile.profile-index');
    }
}
