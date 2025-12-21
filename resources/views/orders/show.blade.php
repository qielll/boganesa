@extends('layouts.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title"> 
                    {{ __('Detail Barang Masuk') }}
                </h2>
            </div>
        </div>

        {{-- @include('partials._breadcrumbs', ['model' => $order]) --}}
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Detail Barang Masuk') }}
                        </h3>
                         <div class="card-actions btn-actions">
                            <div class="dropdown">
                                <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path></svg>
                                </a>
    
                                {{-- <div class="dropdown-menu dropdown-menu-end" style="">
                                    @if ($order->order_status === \App\Enums\OrderStatus::PENDING)
                                        <form action="{{ route('orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('put')
    
                                            <button type="submit" class="dropdown-item text-success"
                                                    onclick="return confirm('Are you sure you want to approve this order?')"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
    
                                                {{ __('Approve Order') }}
                                            </button>
                                        </form>
                                    @endif
                                </div> --}}
                            </div>
    
                            <x-action.close route="{{ route('orders.index') }}"/>
                        </div>
                    </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                            <tbody>
                            {{-- @foreach ($order->details as $item)
                                <tr>
                                    <td class="align-middle text-center">
                                        {{ $loop->iteration  }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <div style="max-height: 80px; max-width: 80px;">
                                            <img class="img-fluid"  src="{{ $item->product->product_image ? asset('storage/products/'.$item->product->product_image) : asset('assets/img/products/default.webp') }}">
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $item->product->name }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $item->product->code }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ number_format($item->unitcost, 2) }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                                <tr><td colspan="2"></td></tr>
                            @endforeach --}}
                            <tr>
                                <td>Nama Barang</td>
                                {{-- <td>{{ number_format($order->pay, 2) }}</td> --}}
                                <td>{{ $order->item_name }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                {{-- <td>{{ number_format($order->due, 2) }}</td> --}}
                                 <td>  {{ $order->category->name }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                {{-- <td>{{ number_format($order->vat, 2) }}</td> --}}
                                 <td> {{ $order->orderDetail?->supplyOrder?->order_quantity }}</td>
                            </tr>
                            <tr>
                                <td>Unit</td>
                                {{-- <td>{{ number_format($order->total, 2) }}</td> --}}
                                 <td> {{ $order->unit->name }}</td>
                            </tr>
                             <tr>
                                <td>Supplier</td> 
                                {{-- <td>{{ number_format($order->total, 2) }}</td> --}}
                                 <td> {{ $order->orderDetail?->supplyOrder?->supplier?->name ?? '-' }}</td>
                            </tr>
                             <tr>
                                <td>Tanggal Masuk</td>
                                {{-- <td>{{ number_format($order->total, 2) }}</td> --}}
                                 <td>{{ $order->orderDetail?->supplyOrder?->order_date->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                             <tr>
                                <td>Tanggal Exp</td>
                                {{-- <td>{{ number_format($order->total, 2) }}</td> --}}
                                <td>  {{ $order->exp_date?->format('d-m-Y') ?? '-' }}</td>
                            </tr>
                             <tr>
                                <td>Lokasi Penyimpanan</td>
                                {{-- <td>{{ number_format($order->total, 2) }}</td> --}}
                                <td>{{ $order->location?->location_name ?? '-' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                    <div class="card-footer text-end">
                        @if ($order->order_status === \App\Enums\OrderStatus::PENDING)
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @method('put')
                            @csrf

                            <button type="submit"
                                    class="btn btn-success"
                                    onclick="return confirm('Are you sure you want to complete this order?')"
                            >
                                {{ __('Complete Order') }}
                            </button>
                        </form>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
