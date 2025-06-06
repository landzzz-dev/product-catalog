@extends('app')

@section('content')
    <section class="place-items-center">
        <div class="xs:w-auto sm:w-[450px]">
            <div class="flex items-center justify-between">
                <span class="text-2xl">Update Product Category</span>
                <a href="{{ route('categories.blade') }}" class="primary">Back</a>
            </div>
            <form action="{{ route('categories.edit', $categoryId) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                @method('PUT')
                @foreach ($categoryObject as $category)
                    <div>
                        <label for="{{ $category['name'] }}">{{ $category['label'] }}<span class="text-red-500">*</span></label>
                        <input 
                            type="text" 
                            class="input"
                            name="{{ $category['name'] }}"
                            value="{{ $category['value'] }}"
                        >
                        @error($category['name'])
                            <p class="text-pink-500">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
                <button class="w-full mt-8 success">Save</button>
            </form>
        </div>
    </section>
@endsection

