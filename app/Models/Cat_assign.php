<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_assign extends Model
{
    protected $table = 'cat_assign';
    protected $fillable = ['item_id', 'cat_id'];

    public function items() {
    	return $this->hasMany('Item');
    }

    public function categories() {
    	return $this->hasMany('Category');
    }
}
