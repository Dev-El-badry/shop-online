<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homepage_Block extends Model
{
    protected $table = 'homepage_blocks';
    protected $fillable = ['block_title', 'priority'];

    public function homepage_offers() {
    	return $this->belongTo('Homepage_Offer');
    }
}
