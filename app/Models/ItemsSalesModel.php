<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsSalesModel extends Model
{
    use HasFactory;
    protected $table = 'items_sales';
    protected $fillable = ['user_id', 'name', 'sku', 'price'];
}
