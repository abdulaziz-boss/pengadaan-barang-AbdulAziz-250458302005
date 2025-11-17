<?php

namespace App\Livewire\Staff\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::withCount('barangs')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orderBy('nama')
            ->paginate(10);

        return view('livewire.staff.categories.category-index', [
            'categories' => $categories,
        ]);
    }
}
