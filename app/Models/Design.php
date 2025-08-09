<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    /** @use HasFactory<\Database\Factories\DesignFactory> */
    use HasFactory;
    protected $fillable = [
        'order_item_id',
        'file_path',
        'note',
        'type',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
