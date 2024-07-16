<?php

namespace App\Models;

use App\Models\Product_Category;
use App\Models\Brand;
use App\Models\UOM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_category_id',
        'brand_id',
        'uom_id',
        'price',
        'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Product_Category::class, 'product_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }
}
