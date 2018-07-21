<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use LaravelLocalization;
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    //$full_url = url('/').LaravelLocalization::getCurrentLocale().'/manage/category/sort';
    protected $except = [

    ];

}
