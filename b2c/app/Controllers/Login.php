<?php namespace App\Controllers;

class Login extends BaseController
{
	public function __construct()
	{
		parent::__construct();
    // echo "<pre>"; print_r($this->session); die(' here ');
		if($this->session->get('loginUserData') != NULL){
      header('Location: '.base_url().'Catalogue');
      exit();
    }
	}

	public function index($autoLogin=NULL)
	{
		$contant['autoLogin'] =  '';
		
		if(!empty($autoLogin))
		{
			parse_str(base64_decode($autoLogin), $autoLogin);
			$user_Email = base64_decode($autoLogin['user_Email']); $user_Password = base64_decode($autoLogin['user_Password']);
			// echo "<pre>$user_Email, $user_Password"; print_r($autoLogin); die(' here ');
			$contant['autoLogin'] =  "user_Email=$user_Email&user_PasswordEncrypt=$user_Password";
		}

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
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			echo "<pre>"; print_r($this->request->getPost()); die(' here ');
			$user_Email = $this->request->getPost('user_Email');
			if(empty($user_Email))
			{
				// set error flash data 
			}
			else
			{
				// validate user
				// if exist then send email and update the password
			}
		}
		$contant['subview'] =  'forget_password';
		return view('page_layout',$contant);
	}

}
