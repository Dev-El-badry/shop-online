<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage_Offer extends Model
{
    protected $table = 'homepage_offers';
    protected $fillable = ['block_id', 'item_id'];
    public $timestamps = false;

    public function items() {
    	return $this->belongsTo('App\Models\Item', 'item_id');
    }

    public function homepage_blocks() {
    	return $this->belongsTo('App\Models\Homepage_Block', 'block_id');
    }
}
