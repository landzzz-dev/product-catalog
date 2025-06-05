<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class BladeProductController extends Controller
{
    public function index()
    {
        $productData = Product::with('categories')->get();

        return view('blade.products.index', [
            'productData' => $productData
        ]);
    }


    public function create()
    {
        $productCategoryData = ProductCategory::all();
        return view('blade.products.create', [
            'productCategoryData' => $productCategoryData
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_category' => 'required|array|min:1',
            'product_category.*' => 'exists:product_categories,id',
            'status' => 'required|boolean', 
        ]);
    
        $product = Product::create([
            'product_name' => $validatedData['product_name'],
            'price' => $validatedData['price'],
            'status' => $validatedData['status'],
        ]);

        $product->categories()->sync($validatedData['product_category']);

        return redirect()->route('products.blade')->with('success', 'Product created successfully!');
    }
    
    
    public function update(Product $product)
    {
        $productCategoryData = ProductCategory::all();
        
        $productObject = [
            [ 'label' => 'Product Name', 'name' => 'product_name', 'value' => $product->product_name ],
            [ 'label' => 'Sell Price', 'name' => 'price', 'value' => $product->price ],
            [ 'label' => 'Product Category', 'name' => 'product_category', 'value' => $product->categories->pluck('id')->toArray() ],
            [ 'label' => 'Active/Inactive Status', 'name' => 'status', 'value' => $product->status ],
        ];

        return view('blade.products.update', [
            'productCategoryData' => $productCategoryData,
            'productObject' => $productObject,
            'productId' => $product->id
        ]);
    }
    

    public function edit(Request $request, $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'product_category' => 'required|array|min:1',
            'product_category.*' => 'exists:product_categories,id',
            'status' => 'required|boolean', 
        ]);

        $product = Product::findOrFail($id);
    
        $product->update([
            'product_name' => $validatedData['product_name'],
            'price' => $validatedData['price'],
            'status' => $validatedData['status'],
        ]);

        $product->categories()->sync($validatedData['product_category']);

        return redirect()->route('products.blade')->with('success', 'Product updated successfully!');
    }


    public function destroy($id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        
        $product->delete();
        
        return redirect()->route('products.blade')->with('success', 'Product deleted successfully!');
    }
}
