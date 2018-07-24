<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table = 'basket';
    protected $fillable = ['item_title', 'price', 'item_qty', 'item_color', 'item_size', 'shopper_id', 'ip_address'];

    public function items() {
    	return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function users() {
    	return $this->belongsTo('App\Models\User');
    }
}
