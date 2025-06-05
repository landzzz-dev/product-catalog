<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $data = ProductCategory::all();
        return response()->json([
            'message' => 'Success',
            'status' => 'ok',
            'data' => $data,
        ]);
    }
}
