<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = ['slider_title', 'target_url'];

    public function slides() {
    	return $this->hasMany('Slide');
    }
}
