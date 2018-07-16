<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webpage extends Model
{
    protected $table = 'webpages';
    protected $fillable = ['page_title', 'page_url', 'page_keywords', 'page_description',  'headline', 'page_content'];

    public function btm_nav() {
    	return $this->belongTo('Btm_nav');
    }
}
