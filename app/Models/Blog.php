<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['blog_title', 'blog_keywords', 'blog_description', 'author', 'picture', 'headline', 'blog_content'];

    
}
