<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['order_ref', 'payment_type', 'payment_id', 'ip_address', 'opened', 'order_status_id', 'shopper_id', 'mc_gross'];

    public function order_status() {
    	return $this->belongsTo('Order_status');
    }

    public function users() {
    	return $this->belongsTo('User');
    }

    public function items() {
    	return $this->belongsTo('Item');
    }
}
