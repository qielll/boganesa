<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class OrderStoreRequest extends FormRequest
{
      public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoiceProducts' => 'required|array|min:1',

            'invoiceProducts.*.item_name'   => 'required|string|max:255',
            'invoiceProducts.*.category_id' => 'required|exists:categories,id',
            'invoiceProducts.*.unit_id'     => 'required|exists:units,id',
            'invoiceProducts.*.supplier_id' => 'required|exists:suppliers,supplier_id',
            'invoiceProducts.*.location_id' => 'required|exists:storage_location,location_id',
            'invoiceProducts.*.quantity'    => 'required|integer|min:1',
            'invoiceProducts.*.price'       => 'nullable|numeric|min:0',
            'invoiceProducts.*.exp_date'    => 'nullable|date',
        ];
    }
}
