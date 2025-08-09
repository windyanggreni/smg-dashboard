<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    /** @use HasFactory<\Database\Factories\OrderStatusLogFactory> */
    use HasFactory;
    protected $fillable = ['order_id', 'status', 'changed_by', 'note'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

}
