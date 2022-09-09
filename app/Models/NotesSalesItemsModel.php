<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesSalesItemsModel extends Model
{
    use HasFactory;
    protected $table = 'note_sales_items';
    protected $fillable = ['user_id', 'note_id', 'item_id', 'quantity', 'price', 'total'];
}
