<?php

namespace App\Livewire\Staff\Barangs;

use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;

class BarangIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $barangs = Barang::with('category')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama', 'asc')
            ->paginate(8);



        return view('livewire.staff.barangs.barang-index', [
            'barangs' => $barangs
        ]);
    }
}
