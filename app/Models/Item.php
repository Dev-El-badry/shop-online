<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
    	'item_title', 'item_url', 'item_description', 'item_price', 'was_price', 'big_img', 'small_img', 'status', 'pdf_file'
    ];

    public function basket() {
    	return $this->belongTo('Basket');
    }

    public function cat_assign() {
    	return $this->belongTo('Cat_assign');
    }

    public function order() {
    	return $this->belongTo('Order');
    }

    public function item_color() {
    	return $this->hasMany('Item_color');
    }

    public function item_size() {
    	return $this->hasMany('Item_size');
    }

    public function homepage_offers() {
    	return $this->belongTo('Homepage_Offer');
    }
}
