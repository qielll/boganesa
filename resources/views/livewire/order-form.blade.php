<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Kategori</th>
                <th>Unit</th>
                <th>Supplier</th>
                <th>Lokasi</th>
                <th>Qty</th>
                <th>Exp</th>
                <th>Price</th>
                <th>Action</th>
                <th>Remove</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoiceProducts as $index => $product)
                <tr>
                    <td><input class="form-control" wire:model="invoiceProducts.{{ $index }}.item_name"></td>

                    <td>
                        <select class="form-select" wire:model="invoiceProducts.{{ $index }}.category_id">
                            <option value="">Pilih</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="form-select" wire:model="invoiceProducts.{{ $index }}.unit_id">
                            <option value="">Pilih</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="form-select" wire:model="invoiceProducts.{{ $index }}.supplier_id">
                            <option value="">Pilih</option>
                            @foreach ($suppliers as $s)
                                <option value="{{ $s->supplier_id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="form-select" wire:model="invoiceProducts.{{ $index }}.location_id">
                            <option value="">Pilih</option>
                            @foreach ($locations as $l)
                                <option value="{{ $l->location_id }}">{{ $l->location_name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="number" class="form-control" wire:model="invoiceProducts.{{ $index }}.quantity"></td>
                    <td><input type="date" class="form-control" wire:model="invoiceProducts.{{ $index }}.exp_date"></td>
                    <td><input type="number" class="form-control" wire:model="invoiceProducts.{{ $index }}.price"></td>

                    <td class="text-center">
                        @if ($product['is_saved'])
                           <button type="button" wire:click="editProduct({{$index}})" class="btn btn-icon btn-outline-warning"> <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg> </button>
                        @else
                            <button type="button" wire:click="saveProduct({{$index}})" class="btn btn-icon btn-outline-success mr-1"> <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg> </button>
                        @endif
                    </td>

                    <td class="text-center">
                        <button type="button" wire:click="removeProduct({{ $index }})" class="btn btn-icon btn-outline-danger"> <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="9"></td>
                <td class="text-center">
                    <button
                    wire:click="addProduct"
                    class="btn btn-success"
                    type="button"
                    @disabled($this->disableAddButton)
>
                        +
                    </button>
             
            </tr>
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
