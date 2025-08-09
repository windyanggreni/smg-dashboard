<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;
    protected $fillable = ['name', 'unit', 'quantity'];

    public function productionLogs()
    {
        return $this->hasMany(ProductionLog::class);
    }


}
