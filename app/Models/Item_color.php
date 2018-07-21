<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_color extends Model
{
    protected $table = 'item_color';
    public $timestamps = false;
    protected $fillable = ['item_id', 'color'];

    public function items() {
    	return $this->belongTo('Item');
    }
}
