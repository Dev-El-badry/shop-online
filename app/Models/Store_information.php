<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store_information extends Model
{
    protected $table = 'store_information';
    public $timestamps = false;


    public function social_networks()
    {
    	return $this->hasMany('App\Models\SocialNetwork', 'parent_id');
    }

    public function shop_dates()
    {
    	return $this->hasMany('App\Models\ShopDate', 'parent_id');
    }
}
