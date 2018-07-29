<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopDate extends Model
{
    protected $table = 'shop_dates';
    public $timestamps = false;

    public function store_information()
    {
    	return $this->belongsTo('App\Models\Store_information', 'parent_id');
    }
}
