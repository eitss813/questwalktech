<?php namespace App\Controllers;

class Dashboard extends BaseController
{

  public function __construct()
	{
		parent::__construct();
    // echo "<pre>"; print_r($this->session->get('loginUserData')); die(' here ');
		if($this->session->get('loginUserData') == NULL){
      header('Location: '.base_url());
      exit();
    }
	}

	public function index()
	{
    // echo "here in dashboard";
    $contant['subview'] =  'dashboard';
		return view('main_layout',$contant);
  }

  public function profile()
	{
    // echo "here in profile";
    $contant['subview'] =  'profile';
		return view('main_layout',$contant);
  }

  public function resetpassword()
	{
    // echo "here in resetpassword";
    $contant['subview'] =  'resetpassword';
		return view('main_layout',$contant);
  }

  public function logout()
  {
    $this->session->destroy();
    header('Location: '.base_url());
    exit();
  }

}
