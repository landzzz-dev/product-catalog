<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pivot_product_categories', 'category_id', 'product_id');
    }
}
