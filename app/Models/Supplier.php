<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
        protected $primaryKey = 'supplier_id';
    protected $fillable = [
        'name','phone','address','shopname','photo','bank_name'
    ];

      public function supplyOrders()
    {
        return $this->hasMany(SupplyOrder::class, 'supplier_id', 'supplier_id');
    }

    public function items()
    {
        return $this->belongsToMany(
            Item::class,
            'supplying',
            'supplier_id',
            'item_id'
        );
    }
}
