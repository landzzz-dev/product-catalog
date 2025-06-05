<?php

namespace App\Http\Controllers\Vue;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Product;

class VueProductController extends Controller
{
    public function index()
    {
        return view('vue.index');
    }


    public function data()
    {
        $productData = Product::with('categories')->get();
        $productCategoryData = ProductCategory::all();

        return response()->json([
            'message' => 'Success',
            'status' => 'ok',
            'data' => [
                'products' => $productData,
                'categories' => $productCategoryData,
            ]
        ], 200);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:product_categories,id',
            'status' => 'required|boolean', 
        ]);

        try {    
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
            ]);

            $product->categories()->sync($validatedData['categories']);

            return response()->json([
                'message' => 'Product created successfully!',
                'status' => 'ok',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:product_categories,id',
            'status' => 'required|boolean', 
        ]);

        try {   
            $product = Product::findOrFail($id);
            
            $product->update([
                'product_name' => $validatedData['product_name'],
                'price' => $validatedData['price'],
                'status' => $validatedData['status'],
            ]);

            $product->categories()->sync($validatedData['categories']);

            return response()->json([
                'message' => 'Product updated successfully!',
                'status' => 'ok',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {

            $product = Product::findOrFail($id);
            
            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully!',
                'staus' => 'ok'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }
}
