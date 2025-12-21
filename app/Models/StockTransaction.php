<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;
        protected $table = 'stock_transaction';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
        protected $casts = [
    'transaction_date' => 'date'
];

     protected $fillable = [
        'item_id','transaction_type','quantity','transaction_date','stock_transaction_notes'
    ];


     public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
