<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slides';
    protected $fillable = ['parent_id', 'target_url', 'alt_text', 'picture'];

    public function sliders() {
    	return $this->belongTo('Slider');
    }
}
