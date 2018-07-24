<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_galleries extends Model
{
    protected $table = 'item_galleries';
    public $timestamps = false;

    public function items()
    {
    	return $this->belongsTo('App\Models\Item', 'parent_id');
    }
}
