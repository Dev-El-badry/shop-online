<?php

namespace App\Traits;

trait SiteSettings 
{

	public function get_currency_symble() {
		return '&dollar;';
	}

	public function not_allowed() {
		return 'not allowed to be here';
	}
}