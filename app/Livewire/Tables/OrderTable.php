<?php

namespace App\Livewire\Tables;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Item;

class OrderTable extends Component
{use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
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
        // $orders = Item::query()
        //     ->with([
        //         'category:id,name',
        //         'unit:id,name',
        //         'location:location_id,location_name',
        //         'orderDetail.supplyOrder.supplier',
        //           'latestStockTransaction',
        //     ])
        //     ->when($this->search, function ($query) {
        //         $query->where('item_name', 'like', '%' . $this->search . '%');
        //     })
        //     ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        //     ->paginate($this->perPage);

        // return view('livewire.tables.order-table', [
        //     'orders' => $orders,
        // ]);

         $orders = Item::query()
        ->whereHas('stockTransactions', function ($q) {
            $q->where('transaction_type', 'in');
        })
        ->with([
            'category:id,name',
            'unit:id,name',
            'location:location_id,location_name',
            'orderDetail.supplyOrder.supplier',
            'inboundStockTransaction',
        ])
        ->when($this->search, function ($query) {
            $query->where('item_name', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

    return view('livewire.tables.order-table', [
        'orders' => $orders,
    ]);
    }
}
