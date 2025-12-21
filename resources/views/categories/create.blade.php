@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3 class="card-title">
                        {{ __('Category Details') }}
                    </h3>
                </div>
                <div class="card-actions">
                    <x-action.close route="{{ route('categories.index') }}" />
                </div>
            </div>
            <form method="POST" action="{{ route('categories.store') }}">
            @csrf
                <div class="card-body">
                     <x-input name="name"  label="Nama Kategori"  :required="true" />
                    <x-input name="slug" label="Link" :required="true" />
                    <x-input name="description" label="Deskripsi Kategori" :required="true" />

                    {{-- <livewire:description /> --}}
                </div>

                <div class="card-footer text-end">
                    <x-button.save type="submit">
                        {{ __('Save') }}
                    </x-button.save>

                    <x-button.back route="{{ route('categories.index') }}">
                        {{ __('Cancel') }}
                    </x-button.back>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
