<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseStockOut extends Model
{
    use HasFactory;

    protected $table = 'warehouse_stock_out';

    protected $fillable = [
        'warehouse_id',
        'product_id',
        'quantity',
        'batch_number',
        'reason',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
