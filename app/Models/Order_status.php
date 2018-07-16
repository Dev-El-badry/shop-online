<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    protected $table = 'order_status';
    protected $fillable = ['order_status_title'];

    public function order() {
    	return $this->hasMany('Order');
    }
}
