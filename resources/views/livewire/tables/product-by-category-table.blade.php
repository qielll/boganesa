<div>
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">
                    Item dengan Kategori: {{ $category->name }}
                </h3>
            </div>

            <div class="card-actions btn-actions">
                <x-action.close route="{{ url()->previous() }}"/>
            </div>
        </div>
 
        <div class="card-body border-bottom py-3">
            <div class="d-flex">
                <div class="text-secondary">
                    Show
                    <div class="mx-2 d-inline-block">
                        <select wire:model.live="perPage" class="form-select form-select-sm" aria-label="result per page">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                    entries
                </div>
                <div class="ms-auto text-secondary">
                    Search:
                    <div class="ms-2 d-inline-block">
                        <input type="text" wire:model.live="search" class="form-control form-control-sm" aria-label="Search invoice">
                    </div>
                </div>
            </div>
        </div>

        <x-spinner.loading-spinner/>

        <div class="table-responsive">
            <table wire:loading.remove class="table table-bordered card-table table-vcenter text-nowrap datatable">
                <thead class="thead-light">
                <tr>
                    {{-- <th class="align-middle text-center w-1">
                        {{ __('No.') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('name')" href="#" role="button">
                            {{ __('Product Name') }}
                            @include('inclues._sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center d-none d-sm-table-cell">
                        <a wire:click.prevent="sortBy('code')" href="#" role="button">
                            {{ __('Product Code') }}
                            @include('inclues._sort-icon', ['field' => 'code'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center d-none d-sm-table-cell">
                        <a wire:click.prevent="sortBy('quantity')" href="#" role="button">
                            {{ __('Product Quantity') }}
                            @include('inclues._sort-icon', ['field' => 'quantity'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Action') }}
                    </th> --}}
                     <th class="align-middle text-center w-1">
                        {{ __('No.') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('name')" href="#" role="button">
                            {{ __('Nama') }}
                            @include('inclues._sort-icon', ['field' => 'name'])
                        </a>
                    </th>
                    {{-- <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('code')" href="#" role="button">
                            {{ __('Code') }}
                            @include('inclues._sort-icon', ['field' => 'code'])
                        </a>
                    </th>  --}}
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('category_id')" href="#" role="button">
                            {{ __('Kategori') }}
                            @include('inclues._sort-icon', ['field' => 'category_id'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('quantity')" href="#" role="button">
                            {{ __('Stok Barang') }}
                            @include('inclues._sort-icon', ['field' => 'quantity'])
                        </a>
                    </th>  
                     <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('unit')" href="#" role="button">
                            {{ __('Unit') }}
                            @include('inclues._sort-icon', ['field' => 'unit'])
                        </a>
                    </th>

                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('quantity_alert')" href="#" role="button">
                            {{ __('Level Reorder/Restock') }}
                            @include('inclues._sort-icon', ['field' => 'quantity_alert'])
                        </a>
                    </th>
                    

                    <th scope="col" class="align-middle text-center">
                        <a href="#" >
                            {{ __('Tanggal Exp') }}
                            {{-- @include('inclues._sort-icon', ['field' => 'quantity_alert']) --}}
                        </a>
                    </th>

                    
                    <th scope="col" class="align-middle text-center">
                        <a href="#" >
                            {{ __('Lokasi Penyimpanan') }}
                            {{-- @include('inclues._sort-icon', ['field' => 'quantity_alert']) --}}
                        </a>
                    </th>

                    <th scope="col" class="align-middle text-center">
                        {{ __('Action') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $product)
                    <tr>
                         <td class="align-middle text-center">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </td>
                        <td class="align-middle">
                            {{ $product->item_name }}
                        </td>
                        {{-- <td class="align-middle text-center">
                            {{ $product->code }}
                        </td> --}}
                        <td class="align-middle text-center">
                            {{ $product->category->name }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $product->item_quantity }}
                        </td>
                        <td class="align-middle text-center">
                            {{ $product->unit->name }}
                        </td>
                        <td class="align-middle text-center"
                            x-data="{ bgColor: 'transparent' }"
                            x-effect="bgColor = getBgColor({{ $product->quantity }}, {{ $product->quantity_alert }})"
                            :style="'background: ' + bgColor"
                        >
                            {{ $product->reorder_level }}
                        </td>
                        <td class="align-middle text-center">
                            {{-- {{ $product->quantity }} --}}
                            {{ $product->exp_date?->format('d-m-Y') ?? '-' }}
                        </td>
                        <td class="align-middle text-center">
                            {{-- {{ $product->quantity }} --}}
                             {{ $product->location?->location_name ?? '-' }}
                        </td>

                        <script>
                            function getBgColor(quantity, quantity_alert) {
                                if (quantity_alert >= quantity) {
                                    return '#f8d7da'; // Red
                                } else if (quantity_alert === quantity - 1 || quantity_alert === quantity - 2) {
                                    return '#fff70063'; // Yellow
                                } 
                                return 'transparent';
                            }
                        </script>

                        <td class="align-middle text-center" style="width: 10%">
                            <x-button.show class="btn-icon" route="{{ route('products.show', $product) }}"/>
                            <x-button.edit class="btn-icon" route="{{ route('products.edit', $product) }}"/>
                            {{-- <x-button.delete class="btn-icon" route="{{ route('products.destroy', $product) }}"/> --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="align-middle text-center" colspan="8">
                            No results found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
                Showing <span>{{ $products->firstItem() }}</span> to <span>{{ $products->lastItem() }}</span> of <span>{{ $products->total() }}</span> entries
            </p>

            <ul class="pagination m-0 ms-auto">
                {{ $products->links() }}
            </ul>
        </div>
    </div>
</div>
