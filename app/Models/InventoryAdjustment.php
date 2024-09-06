<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'adjustment_quantity', 'reason'];

    // Define relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
