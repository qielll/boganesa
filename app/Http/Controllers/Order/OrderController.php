<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatus;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Models\StorageLocation;
use App\Models\Item;
use App\Models\SupplyOrder;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

      public function index()
    {
        // $orders = Item::query()
        //     ->with([
        //         'category:id,name',
        //         'unit:id,name',
        //         'location:location_id,location_name',
        //         'orderDetail.supplyOrder.supplier',
        //           'latestStockTransaction',
        //     ])
        //     ->paginate(10);

        //     // dd($orders);
        //     // dd(DB::connection()->getDatabaseName());
        // return view('orders.index', [
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
        ->paginate(10);

            // dd($orders);
            // dd(DB::connection()->getDatabaseName());
        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
  
public function create()
{
    
   return view('orders.create');
}

    public function store(OrderStoreRequest $request)
{
    DB::transaction(function () use ($request) {

        foreach ($request->invoiceProducts as $row) {

            /** 1. Supply Order */
            $supplyOrder = SupplyOrder::create([
                'supplier_id' => $row['supplier_id'],
                'order_date'  => now(),
                'item_ordered'=> $row['item_name'],
                'order_quantity' => $row['quantity'],
                'item_price'  => $row['price'],
                'total_cost'  => $row['price'] * $row['quantity'],
                'ordered_by'  => auth()->user()->name ?? 'system',
            ]);

            /** 2. Order Detail */
            $orderDetail = OrderDetails::create([
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
                'reorder_level' => 0,
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

    return redirect()
        ->route('orders.index')
        ->with('success', 'Inbound order successfully created');
}

    public function show(Item $order)
    {
        //  $order = Item::query()
        // ->with([
        //     'category:id,name',
        //     'unit:id,name',
        //     'location:location_id,location_name',
        //     'orderDetail.supplyOrder.supplier',
        // ])
        // ->where('item_id', $order->item_id)
        // ->firstOrFail();

    return view('orders.show', [
        'order' => $order,
    ]);
    }

    public function edit(Item $order){
        return view('orders.edit', [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'order' => $order
        ]);
    }

    public function update(Order $order, Request $request)
    {
        // TODO refactoring

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order)->get();

        foreach ($products as $product) {
            Product::where('id', $product->product_id)
                ->update(['quantity' => DB::raw('quantity-' . $product->quantity)]);
        }

        $order->update([
            'order_status' => OrderStatus::COMPLETE,
        ]);

        return redirect()
            ->route('orders.complete')
            ->with('success', 'Order has been completed!');
    }

    public function destroy(Item $order)
{
    // Delete related stock transactions first
    $order->stockTransactions()->delete();

    // Then delete the item
    $order->delete();

    return redirect()
        ->route('orders.index')
        ->with('success', 'Order deleted successfully');
}


    public function downloadInvoice($order)
    {
        $order = Order::with(['customer', 'details'])
            ->where('id', $order)
            ->first();

        return view('orders.print-invoice', [
            'order' => $order,
        ]);
    }
}
