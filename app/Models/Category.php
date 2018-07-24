<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['cat_title', 'cat_url', 'cat_parent_id', 'priority', 'picture'];
    public $timestamps = false;

    // public function cat_assign() {
    // 	return $this->belongsTo('Cat_assign');
    // }

    public function items()
    {
    	$instance =  $this->belongsToMany('App\Models\Item', 'cat_assign', 'cat_id', 'item_id');
    	$instance->where('status', '=', '1');
    	return $instance;

    }

        public function blogs()
    {
        return $this->belongsToMany('App\Models\Blog', 'blog_category', 'cat_id', 'blog_id');
    } 
}
