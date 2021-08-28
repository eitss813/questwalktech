<?php namespace App\Controllers;

class Simulation extends BaseController
{

  protected $CommonModel;
  protected $userId;

  public function __construct()
	{
		parent::__construct();
    $this->CommonModel = new \App\Models\CommonModel();
    // echo "<pre>"; print_r($this->session->get('loginUserData')); die(' here ');
		if($this->session->get('loginUserData') == NULL){
      if(!empty($_REQUEST))
      {
        // echo "<pre>"; print_r($_REQUEST); die( 'here ');
        $useremail = trim($_REQUEST['user_Email']);
        $userpassword = trim($_REQUEST['user_Password']);
        $autoLoginData = base64_encode('user_Email='.$useremail.'&user_Password='.$userpassword);
        header('Location: '.base_url('Login/index/'.$autoLoginData));
      }
      else
      {
        header('Location: '.base_url());
      }
      exit();
    }
    $this->userId = $this->session->get('loginUserData')->user_Id;
	}

	public function index()
	{
    // echo "here in Simulation";
    $cartSql = "SELECT * FROM user_cart WHERE cart_UserId=$this->userId";
    $cartRes = $this->CommonModel->executeQuery($cartSql);
    // echo "<pre>$cartSql<br>"; print_r($cartRes); exit();
    $contant['userGamesInCart'] =  $cartRes;
    
    $catalogLinkSql = "SELECT * FROM catalog_link";
    $dbCatalogSQL = $this->CommonModel->executeQuery($catalogLinkSql);
    $catalogLinkArray = array();
    if( isset($dbCatalogSQL['userData']) && !empty($dbCatalogSQL['userData']) ) {
        $user_email = $this->session->get('loginUserData')->user_Email;
        $user_password = $this->session->get('loginUserData')->user_Password;
        $parent_redirect_url = 'https://simulessons.com/trgroi2/auto-login?user_Email='.$user_email.'&user_Password='.$user_password.'&url=';

        foreach( $dbCatalogSQL['userData'] as $catalogSQL ) {
            $catalogLinkArray[$catalogSQL->game_id] = $catalogSQL->link;
        }
    }
    $contant['catalog_links_array'] = @json_encode($catalogLinkArray);
    $contant['catalog_links_redirection_link'] = !empty($parent_redirect_url)? $parent_redirect_url: '';
    

    $purchaseSql = "SELECT * FROM game_purchase WHERE purchase_userId=$this->userId";
    $dbResult = $this->CommonModel->executeQuery($purchaseSql);
    // echo "<pre>$purchaseSql<br>"; print_r($dbResult); exit();
    $userGames = array();
    if(count($dbResult['userData'])>0)
    {
      foreach($dbResult['userData'] as $gameRows)
      {
        $userGames[] = $gameRows->purchase_gameId;
      }
    }
    $contant['userGames'] =  implode(',',$userGames);
    $contant['subview'] =  'simulation';
    // echo "<pre>"; print_r($contant); die(' here ');
		return view('main_layout',$contant);
  }

  // public function logout()
  // {
  //   $this->session->destroy();
  //   header('Location: '.base_url());
  //   exit();
  // }

}
