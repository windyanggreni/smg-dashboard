<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    /** @use HasFactory<\Database\Factories\ProductionLogFactory> */
    use HasFactory;
    protected $fillable = ['stok_id', 'order_item_id', 'quantity_used'];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stok_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
