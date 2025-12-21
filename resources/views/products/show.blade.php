@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl mb-3">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title"> 
                    {{ __('Edit Product') }}
                </h2>
            </div>
        </div>

        @include('partials._breadcrumbs', ['model' => $product])
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">

            <div class="row">
                {{-- <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">
                                {{ __('Product Image') }}
                            </h3>

                            <img class="img-account-profile mb-2" src="{{ asset('assets/img/products/default.webp') }}" alt="" id="image-preview" />
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Product Details') }}
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td>{{ $product->item_name }}</td>
                                    </tr>



                                    <tr>
                                        <td>Category</td>
                                        <td>
                                            <a href="{{ route('categories.show', $product->category) }}" class="badge bg-blue-lt">
                                                {{ $product->category->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Unit</td>
                                        <td>
                                            <a href="{{ route('units.show', $product->unit) }}" class="badge bg-blue-lt">
                                                {{ $product->unit->short_code }}
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Quantity</td>
                                        <td>{{ $product->item_quantity }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantity Alert</td>
                                        <td>
                                            <span class="badge bg-red-lt">
                                                {{ $product->reorder_level }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Expired</td>
                                        <td>  {{ $product->exp_date?->format('d-m-Y') ?? '-' }}</td>
                                       
                                    </tr>
                                    <tr>
                                        <td>Lokasi Penyimpanan</td>
                                        <td> {{ $product->location?->location_name ?? '-' }}</td>
                                         
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer text-end">
                            <x-button.edit route="{{ route('products.edit', $product) }}">
                                {{ __('Edit') }}
                            </x-button.edit>

                            <x-button.back route="{{ route('products.index') }}">
                                {{ __('Cancel') }}
                            </x-button.back>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
