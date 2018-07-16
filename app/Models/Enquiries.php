<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiries extends Model
{
    protected $table = 'enquiries';
    protected $fillable = ['sent_to', 'sent_by', 'subject', 'message', 'opened', 'code', 'urgent', 'ranking'];
}
