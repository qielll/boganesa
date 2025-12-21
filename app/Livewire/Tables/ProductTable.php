<?php

namespace App\Livewire\Tables;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 25;
    public $search = '';

    // default sort
    public $sortField = 'item.item_id';
    public $sortAsc = false;

    public function sortBy($field): void
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
        $products = Item::query()
            ->select([
                'item.item_id',
                'item.item_name',
                'item.item_quantity',
                'item.reorder_level',
                'item.exp_date',
                'item.category_id',
                'item.unit_id',
                'item.location_id',
            ])
            ->with([
                'category:id,name',
                'unit:id,name',
                'location:location_id,location_name',
            ])
            ->when($this->search, function ($query) {
                $query->where('item.item_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.tables.product-table', [
            'products' => $products,
        ]);
    }
}
