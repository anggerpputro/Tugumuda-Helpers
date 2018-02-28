<?php

namespace Tugumuda\Helpers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class HelpersController extends Controller
{

	public function index($timezone = null)
	{
		$current_time = ($timezone)
						? Carbon::now(str_replace('-', '/', $timezone))
						: Carbon::now();
		return view('timezones::timezone', compact('current_time'));
	}

}
