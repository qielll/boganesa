<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{ __('Tabel Catatan Outbound') }}
            </h3>
        </div>

        <div class="card-actions">
            <x-action.create route="{{ route('purchases.create') }}" />
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
                    <th class="align-middle text-center w-1">
                        {{ __('No.') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Nama Barang') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Kategori') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Jumlah Barang') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Unit') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Supplier') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Tanggal Keluar') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Tanggal Exp') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Lokasi Penyimpanan') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
            @forelse ($purchases as $order)
                <tr>
                    <td class="align-middle text-center">
                        {{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}
                    </td>
                    <td class="align-middle">
                        {{ $order->item_name }}
                    </td>
                    <td class="align-middle text-center">
                         {{ $order->category->name }}
                    </td>
                    <td class="align-middle text-center">
                        {{ $order->outboundStockTransaction?->quantity }}
                    </td>
                    <td class="align-middle text-center">
                         {{ $order->unit->name }}
                    </td>
                    <td class="align-middle">
                        {{ $order->orderDetail?->supplyOrder?->supplier?->name ?? '-' }}
                    </td>
                    
                    <td class="align-middle text-center">
                         {{ $order->outboundStockTransaction?->transaction_date?->format('d-m-Y') ?? '-' }}
                    </td>
                    <td class="align-middle text-center">
                         {{ $order->exp_date?->format('d-m-Y') ?? '-' }}
                    </td>
                    <td class="align-middle text-center">
                        {{ $order->location?->location_name ?? '-' }}
                    </td>
                    <td class="align-middle text-center" style="width: 5%">
                        <x-button.show class="btn-icon" route="{{ route('purchases.show', $order) }}"/>
                        {{-- <x-button.edit class="btn-icon" route="{{ route('orders.edit', $order) }}"/> --}}
                        <x-button.delete class="btn-icon" route="{{ route('purchases.destroy', $order) }}"/>
                         
                        {{-- <x-button.print class="btn-icon" route="{{ route('order.downloadInvoice', $order) }}"/> --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="align-middle text-center" colspan="10">
                        No results found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <span>{{ $purchases->firstItem() }}</span> to <span>{{ $purchases->lastItem() }}</span> of <span>{{ $purchases->total() }}</span> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            {{ $purchases->links() }}
        </ul>
    </div>
</div>
