<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['cat_title', 'cat_url', 'cat_parent_id', 'priority', 'picture'];
    public $timestamps = false;

    public function cat_assign() {
    	return $this->belongTo('Cat_assign');
    }
}
