<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Btm_nav extends Model
{
    protected $table = 'btm_nav';
    protected $fillable = ['page_id', 'priority'];

    public function webpages() {
    	return $this->hasMany('Webpage');
    }
}
