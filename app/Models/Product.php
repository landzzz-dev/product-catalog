<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_name',
        'price',
        'status'
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'pivot_product_categories', 'product_id', 'category_id');
    }
}
