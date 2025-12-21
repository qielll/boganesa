<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLocation extends Model
{
    use HasFactory;

    protected $table = 'storage_location';
    protected $primaryKey = 'location_id';
    public $timestamps = false;
}
