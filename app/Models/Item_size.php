<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_size extends Model
{
    protected $table = 'item_size';
    public $timestamps = false;
    protected $fillable = ['item_id', 'size'];

    public function items() {
    	return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
