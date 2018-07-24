<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cat_assign extends Model
{
    protected $table = 'cat_assign';
    protected $fillable = ['item_id', 'cat_id'];
    public $timestamps = false;

    public function items() {
    	return $this->hasMany(Item::class);
    }

    public function categories() {
    	return $this->hasMany('App\Models\Category');
    }
}
