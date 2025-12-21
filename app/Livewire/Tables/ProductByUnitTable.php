<?php

namespace App\Livewire\Tables;
use App\Models\Unit;
use App\Models\Item;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductByUnitTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 5;

    public string $search = '';

    public string $sortField = 'item_name';

    public bool $sortAsc = true;

    public Unit $unit;

    public function mount(Unit $unit): void
    {
        $this->unit = $unit;
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
            $this->sortField = $field;
        }
    }

    public function render()
    {
        return view('livewire.tables.product-by-unit-table', [
            'products' => Item::query()
                ->where('unit_id', $this->unit->id)
                ->where(function ($query) {
                    $query->where('item_name', 'like', '%' . $this->search . '%')
                          ->orWhere('item_id', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ]);
    }
}