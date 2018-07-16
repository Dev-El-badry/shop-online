<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage_Offer extends Model
{
    protected $table = 'homepage_offers';
    protected $fillable = ['block_id', 'item_id'];

    public function items() {
    	return $this->hasMany('Item');
    }

    public function homepage_blocks() {
    	return $this->hasMany('Homepage_Block');
    }
}
