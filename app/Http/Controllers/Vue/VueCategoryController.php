<?php

namespace App\Http\Controllers\Vue;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class VueCategoryController extends Controller
{
    public function index()
    {
        return view('vue.index');
    }


    public function data()
    {
        $productCategoryData = ProductCategory::all();

        return response()->json([
            'message' => 'Success',
            'status' => 'ok',
            'data' => $productCategoryData
        ], 200);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255|unique:product_categories,category_name'
        ]);

        try {    
            ProductCategory::create([
                'category_name' => $validatedData['category_name']
            ]);

            return response()->json([
                'message' => 'Product Category created successfully!',
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
            'category_name' => 'required|string|max:255|unique:product_categories,category_name'
        ]);

        try {   
            $product = ProductCategory::findOrFail($id);
            
            $product->update([
                'category_name' => $validatedData['category_name']
            ]);

            return response()->json([
                'message' => 'Product Category updated successfully!',
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

            $product = ProductCategory::findOrFail($id);
            
            $product->delete();

            return response()->json([
                'message' => 'Product Category deleted successfully!',
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
