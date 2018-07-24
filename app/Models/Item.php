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
    	return $this->hasMany('App\Models\Basket', 'item_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'cat_assign', 'item_id', 'cat_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'favourite', 'item_id', 'user_id');
    }

    public function order() {
    	return $this->belongsTo('Order');
    }

    public function item_color() {
    	return $this->hasMany('App\Models\Item_color', 'item_id');
    }

    public function item_size() {
    	return $this->hasMany('App\Models\Item_size', 'item_id');
    }

    public function homepage_offers() {
    	return $this->hasMany('App\Models\Homepage_Offer');
    }

    public function item_galleries()
    {
        return $this->hasMany('App\Models\Item_galleries', 'parent_id');
    }
}
