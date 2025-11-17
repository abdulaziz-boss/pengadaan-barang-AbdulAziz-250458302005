<?php

namespace App\Livewire\Staff\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class PengadaanIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pengadaans = Pengadaan::with('pengaju')
            ->where('pengaju_id', Auth::id())
            ->where(function ($query) {
                $query->where('kode_pengadaan', 'like', "%{$this->search}%")
                      ->orWhere('status', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.staff.pengadaans.pengadaan-index', [
            'pengadaans' => $pengadaans
        ]);
    }
}

