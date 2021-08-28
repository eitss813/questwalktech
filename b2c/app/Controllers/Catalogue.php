<?php namespace App\Controllers;

class Catalogue extends BaseController
{

  protected $CommonModel;
  protected $userId;

  public function __construct()
	{
		parent::__construct();
    $this->CommonModel = new \App\Models\CommonModel();
    // echo "<pre>"; print_r($this->session->get('loginUserData')); die(' here ');
		if($this->session->get('loginUserData') == NULL){
      header('Location: '.base_url());
      exit();
    }
    $this->userId = $this->session->get('loginUserData')->user_Id;
	}

	public function index()
	{
    // echo "here in catalogue";
    $cartSql = "SELECT * FROM user_cart WHERE cart_UserId=$this->userId";
    $dbResult = $this->CommonModel->executeQuery($cartSql);
    // echo "<pre>$cartSql<br>"; print_r($dbResult); exit();

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
    
    $contant['subview'] =  'catalogue';
    $contant['userGamesInCart'] =  $dbResult;
    
    $contant['enable_link_btns'] = isset($user_email) && ($user_email == 'contacterdeepaksharma@gmail.com') ? true : false;
		return view('main_layout',$contant);
  }

  public function logout()
  {
    $this->session->destroy();
    header('Location: '.base_url());
    exit();
  }

}
