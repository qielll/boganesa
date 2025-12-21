<div>

    @session('message')
    <div class="p-4 bg-green-100">
        {{ $value }}
    </div>
    @endsession
{{-- 
    <div class="row gx-3 mb-3">
        <div class="col-md-4">
            <label for="customer_id" class="form-label">Customers</label>
            <select class="form-select" name="customer_id" id="customer_id">
                <option selected disabled>Select Customer</option>
                <option value="1">Customer A</option>
                <option value="2">Customer B</option>
            </select>
        </div>
    </div> --}}
    <table class="table table-bordered" id="products_table">
        <thead class="thead-dark">
            <tr>
                <th class="align-middle">Item</th>
                <th class="align-middle">Kategori</th>
                <th class="align-middle">Unit</th>
                <th class="align-middle">Supplier</th>
                <th class="align-middle">Lokasi Penyimpanan</th>
                <th class="align-middle text-center" style="width: 10%;">Jumlah</th>
                {{-- <th class="align-middle text-center" style="width: 9%;">Tanggal Exp</th> --}}
                {{-- <th class="align-middle text-center" style="width: 10%;">Price</th> --}}
                <th class="align-middle text-center">Action</th>
                <th class="align-middle text-center">Remove</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoiceProducts as $index => $invoiceProduct)
            <tr wire:key="invoice-product-{{ $index }}">
                {{-- Item --}}
                {{-- <td class="align-middle">
                    <input type="text" class="form-control" placeholder="Nama Item">
                </td> --}}
                 <td class="align-middle">
                    <select class="form-select"
                            wire:model="invoiceProducts.{{$index}}.item_id"
                            wire:change="itemChanged({{$index}})">
                        <option selected disabled>Pilih Produk</option>
                        @foreach($items as $item)
                            <option value="{{ $item->item_id }}">
                                {{ $item->item_name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                {{-- Kategori --}}
               <td class="align-middle">
                        <select class="form-select" wire:model="invoiceProducts.{{$index}}.category_id" >
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>


                {{-- Unit --}}
              <td class="align-middle">
                    <select class="form-select" wire:model="invoiceProducts.{{$index}}.unit_id" >
                        <option value="">Pilih Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </td>
                              

                {{-- Supplier --}}
                <td class="align-middle">
                   <select class="form-select"
        wire:model="invoiceProducts.{{$index}}.supplier_id" disabled>
                        <option value="">Terpilih Otomatis</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </td>



                {{-- Lokasi Penyimpanan --}}
              <td class="align-middle">
                    <select class="form-select" wire:model="invoiceProducts.{{$index}}.location_id" >
                        <option value="">Pilih Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->location_id }}">{{ $location->location_name }}</option>
                        @endforeach
                    </select>
                </td>


                {{-- Jumlah --}}
                <td class="align-middle text-center" style="width: 10%;">
                    <input type="number"
                           wire:model="invoiceProducts.{{$index}}.quantity"
                           id="invoiceProducts[{{$index}}][quantity]"
                           class="form-control"
                           min="1"
                    />
                </td>

                {{-- Tanggal Exp --}}
                {{-- <td class="align-middle text-center" style="width: 9%;"> 
                    <input type="date" class="form-control">
                </td> --}}

                {{-- Unit Price --}}
                {{-- <td class="align-middle text-center" style="width: 10%;">
                    <input type="number"
                           wire:model="invoiceProducts.{{$index}}.product_price"
                           id="invoiceProducts[{{$index}}][product_price]"
                           class="form-control"
                           min="0"
                           step="any"
                    />
                </td> --}} 

                {{-- Action --}}
                <td class="align-middle text-center">
                    @if($invoiceProduct['is_saved'])
                        <button type="button" wire:click="editProduct({{$index}})" class="btn btn-icon btn-outline-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
                        </button>
                    @else
                        <button type="button" wire:click="saveProduct({{$index}})" class="btn btn-icon btn-outline-success mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                        </button>
                    @endif
                </td>

                {{-- Remove --}}
                <td class="align-middle text-center">
                    <button type="button" wire:click="removeProduct({{$index}})" class="btn btn-icon btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button>
                </td>
            </tr>
            @endforeach

            <tr>
                <td colspan="7"></td>
                <td class="text-center">
                    <button type="button" wire:click="addProduct" class="btn btn-icon btn-success" @disabled($this->disableAddButton)>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    </button>
                </td>
            </tr>
            {{-- <tr>
                <th colspan="9" class="align-middle text-end">
                    Subtotal
                </th>
                <td class="text-center">
                    {{ Number::currency($subtotal, 'EUR') }}
                </td>
            </tr>
            <tr>
                <th colspan="9" class="align-middle text-end">
                    Taxes
                </th>
                <td width="150" class="align-middle text-center">
                    <input wire:model.blur="taxes" type="number" id="taxes" class="form-control w-75 d-inline" min="0" max="100">
                    %

                    @error('taxes')
                    <em class="invalid-feedback">
                        {{ $message }}
                    </em>
                    @enderror
                </td>
            </tr> --}}
            {{-- <tr>
                <th colspan="7" class="align-middle text-end">
                    Total
                </th>
                <td class="text-center">
                    {{ Number::currency($total, 'EUR') }}
                    <input type="hidden" name="total_amount" value="{{ $total }}">
                </td>
            </tr> --}}

        </tbody>
    </table>
    <div style="display: flex; justify-content: end;    ">
        <button
             wire:click="submitOrder"
             class="btn btn-primary"
             type="button">
             Submit
         </button>
    </div>
</div>