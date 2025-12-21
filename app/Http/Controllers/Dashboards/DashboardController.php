<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\SupplyOrder;
use App\Models\StockTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Total inventory items
        $items = Item::count();

        // Categories
        $categories = Category::count();

        // Supply orders (Purchases)
        $purchases = SupplyOrder::count();

    $totalIn = StockTransaction::where('transaction_type', 'in')
        ->sum('quantity');

    $totalOut = StockTransaction::where('transaction_type', 'out')
        ->sum('quantity');

    $todayIn = StockTransaction::where('transaction_type', 'in')
    ->whereDate('transaction_date', today())
    ->count();

    $todayOut = StockTransaction::where('transaction_type', 'out')
    ->whereDate('transaction_date', today())
    ->count();
    
        return view('dashboard', [
            'items' => $items,
            'categories' => $categories,
            'todayIn' => $todayIn,
            'todayOut' => $todayOut,
            'outTransaction' => $totalOut,
            'inTransaction' => $totalIn

        ]);
    }
}
