<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'lastname', 'phone_number', 'picture', 'address1', 'address2', 'country', 'town'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function basket() {
        return $this->hasMany('App\Models\Basket', 'shopper_id');
    }

    public function items()
    {
        return $this->belongsToMany('App\Models\Item', 'favourite', 'user_id', 'item_id');
    }

    public function order() {
        return $this->hasMany('Order');
    }

    public function enquiries()
    {
        return $this->hasMany('App\Models\Enquiries', 'sent_by');
    }
}
