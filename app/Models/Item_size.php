<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_size extends Model
{
    protected $table = 'item_size';

    protected $fillable = ['item_id', 'size'];

    public function items() {
    	return $this->belongTo('Item');
    }
}
