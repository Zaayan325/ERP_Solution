<?php

namespace App\Exports;

use App\Models\WarehouseStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class WarehouseStockExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WarehouseStock::with(['product.category', 'product.brand', 'product.unit'])
            ->get()
            ->map(function($stock) {
                return [
                    'Warehouse' => $stock->warehouse->name,
                    'Product' => $stock->product->name,
                    'Category' => $stock->product->category->name,
                    'Brand' => $stock->product->brand->name,
                    'Unit' => $stock->product->unit->name,
                    'Batch Number' => $stock->batch_number,
                    'Expiry Date' => $stock->expiry_date ? $stock->expiry_date->format('Y-m-d') : 'N/A',
                    'Quantity' => $stock->quantity,
                    'Added On' => $stock->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Warehouse',
            'Product',
            'Category',
            'Brand',
            'Unit',
            'Batch Number',
            'Expiry Date',
            'Quantity',
            'Added On',
        ];
    }
}
