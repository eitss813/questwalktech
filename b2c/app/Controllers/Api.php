<?php namespace App\Controllers;

class Ajax extends BaseController
{
	public function index()
	{
		$contant['subview'] =  'login';
		return view('page_layout',$contant);
  }
  
  public function register()
	{
		$contant['subview'] =  'register';
		return view('page_layout',$contant);
  }
  
  public function forget_password()
	{
		$contant['subview'] =  'forget_password';
		return view('page_layout',$contant);
	}

}
