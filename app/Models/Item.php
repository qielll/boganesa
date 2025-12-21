<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
      protected $table = 'item';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    protected $casts = [
    'exp_date' => 'date',
    'item_quantity' => 'integer'
];

 protected $fillable = [
        'item_name','category_id','unit_id','detailorder_id','location_id','user_id','item_quantity','reorder_level','exp_date','item_date_add'
    ];

    public function getRouteKeyName()
{
    return 'item_id';
}
     public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function location()
    {
        return $this->belongsTo(StorageLocation::class, 'location_id', 'location_id');
    }
      public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'detailorder_id', 'detailorder_id');
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'item_id', 'item_id');
    }

    public function outboundStockTransaction()
{
    return $this->hasOne(StockTransaction::class, 'item_id', 'item_id')->where('transaction_type', 'out');;
}


    public function inboundStockTransaction()
{
    return $this->hasOne(StockTransaction::class, 'item_id', 'item_id')->where('transaction_type', 'in');;
}

    public function suppliers()
    {
        return $this->belongsToMany(
            Supplier::class,
            'supplying',
            'item_id',
            'supplier_id'
        );
    }

    protected static function booted()
{
    static::deleting(function ($item) {
        $item->stockTransactions()->delete(); 
    });
}
    
}
