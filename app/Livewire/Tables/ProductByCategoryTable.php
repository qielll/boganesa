<?php

namespace App\Livewire\Tables;

use App\Models\Product;
use Livewire\Component;
use App\Models\Item;
use App\Models\Category;
use Livewire\WithPagination;

class ProductByCategoryTable  extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;
    public string $search = '';
    public string $sortField = 'item_name';
    public bool $sortAsc = true;

    public Category $category;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'item_name'],
        'sortAsc' => ['except' => true],
    ];

    public function mount(Category $category): void
    {
        $this->category = $category;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc = true;
        }
    }

    public function render()
    {
        return view('livewire.tables.product-by-category-table', [
            'products' => Item::query()
                ->where('category_id', $this->category->id)
                ->when($this->search, function ($query) {
                    $query->where('item_name', 'like', "%{$this->search}%");
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}

