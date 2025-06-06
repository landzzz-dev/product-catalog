@extends('app')

@section('content')
    <section>
        <div class="text-3xl text-center font-bold">Blade Page Products</div>
        <div class="flex flex-row gap-4 w-full justify-space-between">
            <a href="{{ route('products.create') }}" class="primary">Add Product</a>
            {{-- <input class="input" placeholder="Search..." type="text" name="search"> --}}
            <a href="{{ route('categories.blade') }}" class="primary">Switch To Product Categories</a>
        </div>
        <div class="w-full overflow-auto" style="height: calc(100vh - 200px)">
            <table class="table-auto table-header table-body">
                <thead>
                    <tr class="bg-slate-50">
                        <th>Product Name</th>
                        <th>Sell Price</th>
                        <th>Product Category</th>
                        <th>Active/Inactive Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productData as $product)
                        <tr class="{{ $product->status ? 'hover:bg-slate-50' : 'hover:bg-slate-50 bg-red-50' }}">
                            <td>{{ $product->product_name }}</td>
                            <td>₱{{ number_format($product->price) }}</td>
                            <td>
                                @foreach ($product->categories as $category)
                                    <li>{{ $category->category_name }}</li>
                                @endforeach
                            </td>
                            <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('products.update', ['product' => $product]) }}" class="success mr-[2px]">Edit</a>
                                <button onclick="deleteProduct({{ $product }})" class="error">Delete</button>
                                <!-- HIDDEN DELETE FORM -->
                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.delete', ['product' => $product->id]) }}" method="POST" style="display:none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script>
        function deleteProduct(product) {
            if (confirm(`Are you sure you want to delete ${product.product_name}?`)) {
            const form = document.getElementById('delete-form-' + product.id);
                if (form) {
                    form.submit();
                }
            }
        }
    </script>
@endsection