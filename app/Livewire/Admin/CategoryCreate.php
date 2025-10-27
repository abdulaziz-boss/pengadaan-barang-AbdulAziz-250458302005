<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryCreate extends Component
{
    public $nama;
    public $deskripsi;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->reset(['nama', 'deskripsi']);

        // dispatch dengan 2 argumen → event + payload
        $this->dispatch('swal');
    }

    public function render()
    {
        return view('livewire.admin.category-create');
    }
}
