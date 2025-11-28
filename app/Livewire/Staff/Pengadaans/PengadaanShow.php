<?php

namespace App\Livewire\Staff\Pengadaans;

use Livewire\Component;
use App\Models\Pengadaan;

class PengadaanShow extends Component
{
    public $pengadaan;

    public function mount($id)
    {
        $this->pengadaan = Pengadaan::with(['pengaju', 'items.barang'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.staff.pengadaans.pengadaan-show');
    }
}
