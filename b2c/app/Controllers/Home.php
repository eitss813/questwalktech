<?php namespace App\Controllers;

class Home extends MainController
{
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
