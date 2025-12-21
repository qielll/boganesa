<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyOrder extends Model
{
    use HasFactory;
      protected $table = 'supply_order';
    protected $primaryKey = 'supply_order_id';
    public $timestamps = false;
    protected $casts = [
    'order_date' => 'date',
    'order_quantity' => 'integer'

];
 protected $fillable = [
        'supplier_id','order_date','order_quantity','item_price','total_cost','ordered_by'
    ];


      public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'supply_order_id', 'supply_order_id');
    }
}
