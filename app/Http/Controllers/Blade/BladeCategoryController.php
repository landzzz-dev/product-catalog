<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class BladeCategoryController extends Controller
{
    public function index()
    {
        $categoryData = ProductCategory::get();

        return view('blade.categories.index', [
            'categoryData' => $categoryData
        ]);
    }


    public function create()
    {
        $productCategoryData = ProductCategory::all();
        return view('blade.categories.create', [
            'productCategoryData' => $productCategoryData
        ]);
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name'
        ]);
    
        ProductCategory::create([
            'category_name' => $validatedData['category_name']
        ]);

        return redirect()->route('categories.blade')->with('success', 'Product Category created successfully!');
    }
    
    
    public function update(ProductCategory $category)
    {
        $categoryObject = [
            [ 'label' => 'Category Name', 'name' => 'category_name', 'value' => $category->category_name ]
        ];

        return view('blade.categories.update', [
            'categoryObject' => $categoryObject,
            'categoryId' => $category->id
        ]);
    }
    

    public function edit(Request $request, $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name'
        ]);

        $product = ProductCategory::findOrFail($id);
    
        $product->update([
            'category_name' => $validatedData['category_name']
        ]);

        return redirect()->route('categories.blade')->with('success', 'Product Category updated successfully!');
    }


    public function destroy($id): RedirectResponse
    {
        $product = ProductCategory::findOrFail($id);
        
        $product->delete();
        
        return redirect()->route('categories.blade')->with('success', 'Product Category deleted successfully!');
    }
}
