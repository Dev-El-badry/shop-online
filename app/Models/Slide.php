<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';
    protected $fillable = ['parent_id', 'target_url', 'alt_text', 'picture'];
    public $timestamps = false;

    public function sliders() {
    	return $this->belongsTo('App\Models\Slider', 'parent_id');
    }

    public function items()
    {
    	return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
