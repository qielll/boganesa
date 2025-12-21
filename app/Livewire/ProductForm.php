<?php

namespace App\Livewire;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\OrderDetail;
use App\Models\SupplyOrder;
use App\Models\StockTransaction;
use App\Models\StorageLocation;
use Livewire\Component;
 use Illuminate\Support\Facades\DB;


class ProductForm extends Component
{
    public array $invoiceProducts = [];

    public $items;
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
        $this->items = Item::select('item_id','item_name')->get();

        $this->addProduct();
    }

    public function render(): View
    {
        return view('livewire.product-form');
    }

    /* =========================
     | Row Management
     ========================= */

    public function addProduct(): void
    {
        if ($this->hasUnsavedRow()) return;

        $this->invoiceProducts[] = [
            'item_id'   => null,
            'category_id' => null,
            'unit_id'     => null,
            'supplier_id' => null,
            'location_id' => null,
            'quantity'    => 1,
            // 'exp_date'    => null,
            'price'       => 0,
            'is_saved'    => false,
        ];
    }

     public function itemChanged(int $index): void
{
    $itemId = $this->invoiceProducts[$index]['item_id'] ?? null;

    if (! $itemId) {
        return;
    }

    $item = Item::with([
        'category:id,name',
        'unit:id,name',
        'suppliers',
        'location:location_id,location_name',
    ])->find($itemId);

    if (! $item) {
        return;
    }

    $this->invoiceProducts[$index]['category_id'] = $item->category_id;
    $this->invoiceProducts[$index]['unit_id']     = $item->unit_id;
    $this->invoiceProducts[$index]['location_id'] = $item->location_id;

    // take FIRST supplier if many-to-many
    $this->invoiceProducts[$index]['supplier_id']
        = $item->suppliers->first()?->supplier_id;
}

     public function editProduct(int $index): void
    {
       
        $this->invoiceProducts[$index]['is_saved'] = false;
    }

    public function saveProduct(int $index): void
    {
        $this->validate([
            "invoiceProducts.$index.item_id"   => 'required',
            "invoiceProducts.$index.category_id" => 'required',
            "invoiceProducts.$index.unit_id"     => 'required',
            "invoiceProducts.$index.supplier_id" => 'required',
            "invoiceProducts.$index.location_id" => 'required',
            "invoiceProducts.$index.quantity"    => 'required|min:1',
            "invoiceProducts.$index.price"       => 'required|min:0',
        ]);

        $this->invoiceProducts[$index]['is_saved'] = true;
    }

    public function removeProduct(int $index): void
    {
        unset($this->invoiceProducts[$index]);
        $this->invoiceProducts = array_values($this->invoiceProducts);
    }

    /* =========================
     | Helpers
     ========================= */

    public function getDisableAddButtonProperty(): bool
    {
        return $this->hasUnsavedRow();
    }

    private function hasUnsavedRow(): bool
    {
        foreach ($this->invoiceProducts as $row) {
            if (! ($row['is_saved'] ?? false)) {
                return true;
            }
        }

        return false;
    }

    public function submitOrder(): void
{
    foreach ($this->invoiceProducts as $product) {
        if (!($product['is_saved'] ?? false)) {
            $this->addError('invoiceProducts', 'Please save all products before submitting.');
            return;
        }
    }

    DB::transaction(function () {

        foreach ($this->invoiceProducts as $row) {

         
            $supplyOrder = SupplyOrder::create([
                'supplier_id'  => $row['supplier_id'],
                'order_date'   => now(),
                'item_ordered' => 'Auto generated from inbound',
                'order_quantity' => $row['quantity'],
                'ordered_by'   => auth()->user()->name ?? 'system',
                'total_cost'   => $row['price'],
            ]);

            
            $orderDetail = OrderDetail::create([
                'supply_order_id' => $supplyOrder->supply_order_id,
                'payment_type'    => 'cash',
            ]);

            $item = Item::where('item_id', $row['item_id'])
                ->lockForUpdate()
                ->firstOrFail();

          
            $item->increment('item_quantity', $row['quantity']);

     
            StockTransaction::create([
                'item_id'          => $item->item_id,
                'detailorder_id'   => $orderDetail->detailorder_id, 
                'transaction_type' => 'in',
                'quantity'         => $row['quantity'],
                'transaction_date' => now(),
                'stock_transaction_notes' => 'Inbound via supply order #' . $supplyOrder->supply_order_id,
            ]);
        }
    });

    session()->flash('message', 'Stock successfully added');

    $this->invoiceProducts = [];
    $this->addProduct();
}
}
