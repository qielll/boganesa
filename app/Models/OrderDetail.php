<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';
    protected $primaryKey = 'detailorder_id';
    public $timestamps = false;
     protected $fillable = [
        'supply_order_id'
    ];
      public function supplyOrder()
    {
        return $this->belongsTo(SupplyOrder::class, 'supply_order_id', 'supply_order_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'detailorder_id', 'detailorder_id');
    }
}
