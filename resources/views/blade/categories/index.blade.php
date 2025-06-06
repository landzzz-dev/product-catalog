@extends('app')

@section('content')
    <section>
        <div class="text-3xl text-center font-bold">Blade Page Product Categories</div>
        <div class="flex flex-row gap-4 w-full justify-space-between">
            <a href="{{ route('categories.create') }}" class="primary">Add Product Category</a>
            {{-- <input class="input" placeholder="Search..." type="text" name="search"> --}}
            <a href="{{ route('products.blade') }}" class="primary">Switch To Products</a>
        </div>
        <div class="w-full overflow-auto" style="height: calc(100vh - 200px)">
            <table class="table-auto table-header table-body">
                <thead>
                    <tr class="bg-slate-50">
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoryData as $category)
                        <tr class="hover:bg-slate-50">
                            <td>{{ $category->id}}</td>
                            <td>{{ $category->category_name }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('categories.update', ['category' => $category]) }}" class="success mr-[2px]">Edit</a>
                                <button onclick="deleteProductCategory({{ $category }})" class="error">Delete</button>
                                <!-- HIDDEN DELETE FORM -->
                                <form id="delete-form-{{ $category->id }}" action="{{ route('categories.delete', ['category' => $category->id]) }}" method="POST" style="display:none">
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
        function deleteProductCategory(category) {
            if (confirm(`Are you sure you want to delete ${category.category_name}?`)) {
            const form = document.getElementById('delete-form-' + category.id);
                if (form) {
                    form.submit();
                }
            }
        }
    </script>
@endsection