<?php

namespace App\Http\Controllers\Product;
;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Item;
use App\Models\StorageLocation;
use App\Models\Unit;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    public function index()
    {
         $products = Item::query()
            ->select([
                'item.item_id',
                'item.item_name as name',
                'item.item_quantity as quantity',
                'item.reorder_level as quantity_alert',
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
            ->paginate(10);

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
        $categories = Category::all(['id', 'name']);
        $units = Unit::all(['id', 'name']);

        if ($request->has('category')) {
            $categories = Category::whereSlug($request->get('category'))->get();
        }

        if ($request->has('unit')) {
            $units = Unit::whereSlug($request->get('unit'))->get();
        }

        return view('products.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $existingProduct = Product::where('code', $request->get('code'))->first();
        
        if ($existingProduct) {
            $newCode = $this->generateUniqueCode();
            
            $request->merge(['code' => $newCode]);
        }

        try {
            $product = Product::create($request->all());

            /**
             * Handle image upload
             */
            if ($request->hasFile('product_image')) {
                $file = $request->file('product_image');
                $filename = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

                // Validate file before uploading
                if ($file->isValid()) {
                    $file->storeAs('products/', $filename, 'public');
                    $product->update([
                        'product_image' => $filename
                    ]);
                } else {
                    return back()->withErrors(['product_image' => 'Invalid image file']);
                }
            }

            return redirect()
                ->back()
                ->with('success', 'Product has been created with code: ' . $product->code);

        } catch (\Exception $e) {
            // Handle any unexpected errors
            return back()->withErrors(['error' => 'Something went wrong while creating the product']);
        }
    }

    // Helper method to generate a unique product code
    private function generateUniqueCode()
    {
        do {
            $code = 'PC' . strtoupper(uniqid());
        } while (Product::where('code', $code)->exists()); 

        return $code;
    }

    public function show(Item $product)
    {
        // // Generate a barcode
        // $generator = new BarcodeGeneratorHTML();

        // $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            // 'barcode' => $barcode,
        ]);
    }

    public function edit(Item $product)
    {

        // dd($product);
        return view('products.edit', [
            'categories' => Category::all(),
            'units' => Unit::all(),
            'locations' => StorageLocation::all(),
            'product' => $product,
           
        ]);
    }

    public function update(UpdateProductRequest $request, Item $product)
    {
        // $product->update($request->except('product_image','_token'));
        
    $product->update($request->validated());

        if ($request->hasFile('product_image')) {

            // Delete old image if exists
            if ($product->product_image) {
                Storage::disk('public')->delete('products/' . $product->product_image);
            }

            // Prepare new image
            $file = $request->file('product_image');
            $fileName = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            // Store new image to public storage
            $file->storeAs('products/', $fileName, 'public');

            // Save new image name to database
            $product->update([
                'product_image' => $fileName
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated!');
    }

    public function destroy(Item $product)
    {
        /**
         * Delete photo if exists.
         */
        if ($product->product_image) {
            \Storage::disk('public')->delete('products/' . $product->product_image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted!');
    }
}
