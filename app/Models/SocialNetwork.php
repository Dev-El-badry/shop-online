<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $table = 'social_networks';
    public $timestamps = false;

    public function store_information()
    {
    	return $this->belongsTo('App\Models\Store_information', 'parent_id');
    }
}
