<?php

namespace App\Imports;

use App\Models\WarehouseStock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class WarehouseStockImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $warehouseStock = WarehouseStock::firstOrCreate(
            [
                'warehouse_id' => $row['warehouse_id'],
                'product_id' => $row['product_id'],
                'batch_number' => $row['batch_number'] ?? null,  // Handle optional batch_number
                'expiry_date' => isset($row['expiry_date']) ? \Carbon\Carbon::parse($row['expiry_date']) : null,  // Handle optional expiry_date
            ],
            ['quantity' => 0]
        );

        $warehouseStock->quantity += $row['quantity'];
        $warehouseStock->save();

        return $warehouseStock;

    }
}
