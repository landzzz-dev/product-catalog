@extends('app')

@php
$productObject = [
    [ 'label' => 'Category Name', 'name' => 'category_name' ],
];
@endphp

@section('content')
    <section class="place-items-center">
        <div class="xs:w-auto sm:w-[450px]">
            <div class="flex items-center justify-between">
                <span class="text-2xl">Create Product Category</span>
                <a href="{{ route('categories.blade') }}" class="primary">Back</a>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col gap-3">
                @csrf
                @foreach ($productObject as $product)
                    <div>
                    <label for="{{ $product['name'] }}">{{ $product['label'] }}<span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            name="{{ $product['name'] }}"
                            class="input @error($product['name']) is-invalid @enderror"
                        >
                        @error($product['name'])
                            <p class="text-pink-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
                <button class="w-full mt-8 success">Save</button>
            </form>
        </div>
    </section>
@endsection



