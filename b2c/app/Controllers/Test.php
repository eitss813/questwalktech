<?php 
namespace App\Controllers;

class Test extends Controller
{
	protected $userModel;

	public function __construct()
  {
		// parent::__construct(); // BaseController has no controller
		$this->userModel = new \App\Models\CommonModel();
  }
	
	
	public function index()
	{
		// return view('welcome_message');
		$db = \Config\Database::connect();
		echo '<pre>';
		print_r($db);
		// print_r($this->userModel);
  }
    
	public function functionOne()
	{
		echo "<pre>this is function one ".date('d-m-Y H:i:s').'<br>';
		echo date_default_timezone_get();
		print_r(get_defined_constants(true)['user']);
		print_r(getenv());
		print_r($_SERVER);
		print_r($_ENV);
		$filters = new \Config\Filters();
		print_r($filters);
	}

	public function redirection($para=NULL, $para2=NULL)
	{
    echo "here in dashboard with $para ".base_url()." ".site_url();
    print_r(uri_string());
  }

}
