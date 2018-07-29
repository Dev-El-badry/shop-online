<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Enquiries;
use App\Models\Item;
use App\Traits\SiteSettings;

class DashboardController extends Controller
{
	use SiteSettings;
    public function index() 
    {
    	$user_count = User::count();
    	$users = User::orderBy('id', 'desc')->take(8)->get();
    	$enquireies_count = Enquiries::count();
    	$enquiries = Enquiries::orderBy('id', 'desc')->take(8)->get();
    	$items_count = Item::count();
    	$items = Item::orderBy('id', 'desc')->take(5)->get();
    	$currencySymbol = $this->get_currency_symble();
    	return view('manage.dashboard', compact('user_count', 'enquireies_count', 'items_count', 'items', 'currencySymbol', 'users','enquiries'));
    }
}
