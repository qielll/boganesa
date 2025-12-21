<?php

namespace App\Livewire;
 use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\OrderDetail;
use App\Models\Item;
use App\Models\SupplyOrder;
use App\Models\StockTransaction;
use App\Models\StorageLocation;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OrderForm extends Component
{
    public array $invoiceProducts = [];

    public $categories;
    public $units;
    public $suppliers;
    public $locations;

    public function mount(): void
    {
        $this->categories = Category::select('id','name')->get();
        $this->units      = Unit::select('id','name')->get();
        $this->suppliers  = Supplier::select('supplier_id','name')->get();
        $this->locations  = StorageLocation::select('location_id','location_name')->get();

        $this->addProduct();
    }

    public function render()
    {
        return view('livewire.order-form');
    }

    public function addProduct(): void
    {
        if ($this->hasUnsavedRow()) return;

        $this->invoiceProducts[] = [
            'item_name'   => '',
            'category_id' => null,
            'unit_id'     => null,
            'supplier_id' => null,
            'location_id' => null,
            'quantity'    => 1,
            'exp_date'    => null,
            'price'       => 0,
            'is_saved'    => false,
        ];
    }

    public function saveProduct(int $index): void
    {
        $this->validate([
            "invoiceProducts.$index.item_name"   => 'required',
            "invoiceProducts.$index.category_id" => 'required',
            "invoiceProducts.$index.unit_id"     => 'required',
            "invoiceProducts.$index.supplier_id" => 'required',
            "invoiceProducts.$index.location_id" => 'required',
            "invoiceProducts.$index.quantity"    => 'required|min:1',
            "invoiceProducts.$index.price"       => 'required|min:0',
        ]);

        $this->invoiceProducts[$index]['is_saved'] = true;
    }

    public function editProduct(int $index): void
    {
        if ($this->hasUnsavedRow()) return;

        $this->invoiceProducts[$index]['is_saved'] = false;
    }

    public function removeProduct(int $index): void
    {
        unset($this->invoiceProducts[$index]);
        $this->invoiceProducts = array_values($this->invoiceProducts);
    }

    public function getDisableAddButtonProperty(): bool
    {
        return $this->hasUnsavedRow();
    }

    private function hasUnsavedRow(): bool
    {
        foreach ($this->invoiceProducts as $row) {
            if (! $row['is_saved']) return true;
        }
        return false;
    }

   

public function submitOrder(): void
{
    // Make sure all rows are saved
    foreach ($this->invoiceProducts as $index => $product) {
        if (!($product['is_saved'] ?? false)) {
            $this->addError('invoiceProducts', 'Please save all products before submitting.');
            return;
        }
    }

    DB::transaction(function () {
        foreach ($this->invoiceProducts as $row) {

            /** 1. Supply Order */
            $supplyOrder = SupplyOrder::create([
                'supplier_id' => $row['supplier_id'],
                'order_date'  => now(),
                'order_quantity' => $row['quantity'],
                'item_price'  => $row['price'],
                'total_cost'  => $row['price'] * $row['quantity'],
                'ordered_by'  => auth()->user()->name ?? 'system',
            ]);

            /** 2. Order Detail */
            $orderDetail = OrderDetail::create([
                'supply_order_id' => $supplyOrder->supply_order_id,
            ]);

            /** 3. Item */
            $item = Item::create([
                'item_name'     => $row['item_name'],
                'category_id'   => $row['category_id'],
                'unit_id'       => $row['unit_id'],
                'detailorder_id'=> $orderDetail->detailorder_id,
                'location_id'   => $row['location_id'],
                'user_id'       => auth()->id(),
                'item_quantity' => $row['quantity'],
                'reorder_level' => 10,
                'exp_date'      => $row['exp_date'],
                'item_date_add' => now(),
            ]);

            /** 4. Stock Transaction (IN) */
           StockTransaction::create([
                'item_id'           => $item->item_id,
                'transaction_type'  => 'in',
                'quantity'          => $row['quantity'],
                'transaction_date'  => now(),
                'stock_transaction_notes' => 'Inbound stock',
            ]);
        }
    });

    session()->flash('message', 'Inbound order successfully created!');

    // Reset the form
    $this->invoiceProducts = [];
    $this->addProduct();
}
}
