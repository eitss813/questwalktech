<?php namespace App\Controllers;

class Ajax extends BaseController
{
  // protected $request;
  // protected $session;
  protected $CommonModel;
  protected $userId;
  protected $sendEmail;

	public function __construct()
	{
    parent::__construct();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // $this->request = \Config\Services::request();
    // print_r($this->request);
    // $this->session = \Config\Services::session();
    // print_r($this->session);
    $this->CommonModel = new \App\Models\CommonModel();
    $this->sendEmail = \Config\Services::email();
    helper('function');

    // $this->session = \Config\Services::session();
    if($this->session->get('loginUserData') != NULL || $this->session->get('loginUserData') != '')
    {
      $this->userId = $this->session->get('loginUserData')->user_Id;
    }
  }

  public function createUser()
	{
    // print_r($this->validation); die(' here ');
    // print_r($this->request->getPost()); die('here in Ajax::register');
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $user_Fname = $this->request->getPost('user_Fname');
      $user_Lname = $this->request->getPost('user_Lname');
      $user_Email = $this->request->getPost('user_Email');
      $user_UserName = $this->request->getPost('user_UserName');
      $user_Phone = $this->request->getPost('user_Phone');
      $user_PasswordEncrypt = $this->request->getPost('user_PasswordEncrypt');
      $user_PasswordEncrypt_re = $this->request->getPost('user_PasswordEncrypt_re');

      // validation starts here
      $this->validation->setRules([
        'user_Fname' => [
          'label' => 'First Name',
          'rules' => 'required|alpha',
          'errors' => ['alpha' => 'The First Name field may only contain alphabetical characters.'],
        ],

        'user_Lname' => [
          'label' => 'Last Name',
          'rules' => 'required|alpha',
          'errors' => ['alpha' => 'The Last Name field may only contain alphabetical characters.'],
        ],

        'user_Email' => [
          'label' => 'Email',
          'rules' => 'required|valid_email|is_unique[game_users.user_Email]',
          'errors' => ['alpha' => 'The Email field may only contain alphabetical characters.'],
        ],

        'user_UserName' => [
          'label' => 'Username',
          'rules' => 'required|alpha_numeric|is_unique[game_users.user_UserName]',
          'errors' => ['alpha' => 'The Username field may only contain alphabetical characters.'],
        ],

        'user_Phone' => [
          'label' => 'Phone Number',
          'rules' => 'required|numeric|exact_length[10]|is_unique[game_users.user_Phone]',
          'errors' => ['alpha' => 'The Phone No. field may only contain alphabetical characters.'],
        ],

        'user_PasswordEncrypt' => [
          'label' => 'Password',
          'rules' => 'required|min_length[5]',
          'errors' => ['alpha' => 'The Password field may only contain alphabetical characters.'],
        ],

        'user_PasswordEncrypt_re' => [
          'label' => 'Confirm Password',
          'rules' => 'required|min_length[5]|matches[user_PasswordEncrypt]',
          'errors' => ['alpha' => 'The Confirm Password field may only contain alphabetical characters.'],
        ],
      ]);
      // validation ends here
      $validate = $this->validation->withRequest($this->request)->run();
      // var_dump($this->validation->withRequest($this->request)->run());
      $errors = $this->validation->getErrors();
      // show errors here and die, if no error then go ahead
      // print_r($errors); print_r($this->validation); die(' after error ');

      if($validate === false)
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There have been validation errors. Please check.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $errors)));
      }
      $userArray = array(
        'user_Fname' => $user_Fname,
        'user_Lname' => $user_Lname,
        'user_Email' => $user_Email,
        'user_UserName' => $user_UserName,
        'user_Phone' => $user_Phone,
        'user_Password' => $user_PasswordEncrypt,
        'user_PasswordEncrypt' => md5($user_PasswordEncrypt_re),
        'user_CreatedMedium' => 'api('.time().')',
        'user_AccountVerification' => 1, // 0-pending for email verification
        'user_CreatedBy' => -21, // -21 for self creation
        // 'User_status' => 0, // 0-Active, 1-DeActive
      );
      $whereArray = array(
        'user_Email' => $user_Email,
        'user_UserName' => $user_UserName,
        'user_Phone' => $user_Phone,
      );

      $dbResult = $this->CommonModel->register($userArray, $whereArray);
      // echo $dbResult['code']; echo $dbResult['msg']; // print_r($userArray); print_r($whereArray);
      if($dbResult['code'] == 200)
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'].' Please Login.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'], 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Registration failed. Please refresh and try later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }
  
    public function resetpasswordViaApi() {
        $user_Email = $this->request->getPost('userEmail');
        $newPassword = $this->request->getPost('newPassword');

        if (empty($user_Email) || empty($newPassword)) {
            die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Email or Password Are Empty.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => '')));
        } else {
            $updateSql = "UPDATE game_users SET user_Password='" . $newPassword . "' , user_PasswordEncrypt='" . md5($newPassword) . "' WHERE user_Email='" . $user_Email . "'";

            $updateRes = $this->CommonModel->executeQuery($updateSql);

            die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Password changed successfully', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
        }
    }

  public function register()
	{
    // print_r($this->validation); die(' here ');
    // print_r($this->request->getPost()); die('here in Ajax::register');
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $user_Fname = $this->request->getPost('user_Fname');
      $user_Lname = $this->request->getPost('user_Lname');
      $user_Email = $this->request->getPost('user_Email');
      $user_UserName = $this->request->getPost('user_UserName');
      $user_Phone = $this->request->getPost('user_Phone');
      $user_PasswordEncrypt = $this->request->getPost('user_PasswordEncrypt');
      $user_PasswordEncrypt_re = $this->request->getPost('user_PasswordEncrypt_re');

      // validation starts here
      $this->validation->setRules([
        'user_Fname' => [
          'label' => 'First Name',
          'rules' => 'required|alpha',
          'errors' => ['alpha' => 'The First Name field may only contain alphabetical characters.'],
        ],

        'user_Lname' => [
          'label' => 'Last Name',
          'rules' => 'required|alpha',
          'errors' => ['alpha' => 'The Last Name field may only contain alphabetical characters.'],
        ],

        'user_Email' => [
          'label' => 'Email',
          'rules' => 'required|valid_email|is_unique[game_users.user_Email]',
          'errors' => ['alpha' => 'The Email field may only contain alphabetical characters.'],
        ],

        'user_UserName' => [
          'label' => 'Username',
          'rules' => 'required|alpha_numeric|is_unique[game_users.user_UserName]',
          'errors' => ['alpha' => 'The Username field may only contain alphabetical characters.'],
        ],

        'user_Phone' => [
          'label' => 'Phone Number',
          'rules' => 'required|numeric|exact_length[10]|is_unique[game_users.user_Phone]',
          'errors' => ['alpha' => 'The Phone No. field may only contain alphabetical characters.'],
        ],

        'user_PasswordEncrypt' => [
          'label' => 'Password',
          'rules' => 'required|min_length[5]',
          'errors' => ['alpha' => 'The Password field may only contain alphabetical characters.'],
        ],

        'user_PasswordEncrypt_re' => [
          'label' => 'Confirm Password',
          'rules' => 'required|min_length[5]|matches[user_PasswordEncrypt]',
          'errors' => ['alpha' => 'The Confirm Password field may only contain alphabetical characters.'],
        ],
      ]);
      // validation ends here
      $validate = $this->validation->withRequest($this->request)->run();
      // var_dump($this->validation->withRequest($this->request)->run());
      $errors = $this->validation->getErrors();
      // show errors here and die, if no error then go ahead
      // print_r($errors); print_r($this->validation); die(' after error ');

      if($validate === false)
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There have been validation errors. Please check.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $errors)));
      }
      $userArray = array(
        'user_Fname' => $user_Fname,
        'user_Lname' => $user_Lname,
        'user_Email' => $user_Email,
        'user_UserName' => $user_UserName,
        'user_Phone' => $user_Phone,
        'user_Password' => $user_PasswordEncrypt,
        'user_PasswordEncrypt' => md5($user_PasswordEncrypt_re),
        'user_CreatedMedium' => 'registrationPage('.time().')',
        'user_AccountVerification' => 1, // 0-pending for email verification
        'user_CreatedBy' => -21, // -21 for self creation
        // 'User_status' => 0, // 0-Active, 1-DeActive
      );
      $whereArray = array(
        'user_Email' => $user_Email,
        'user_UserName' => $user_UserName,
        'user_Phone' => $user_Phone,
      );

      $dbResult = $this->CommonModel->register($userArray, $whereArray);
      // echo $dbResult['code']; echo $dbResult['msg']; // print_r($userArray); print_r($whereArray);
      if($dbResult['code'] == 200)
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'].' Please Login.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'], 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Registration failed. Please refresh and try later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }

  public function createHash($hashString=NULL)
  {
    if(empty($hashString))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Not a valid string for creating hash.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      $hashString = trim(base64_decode($hashString),"'");
      $stringHash = hash('sha512', $hashString);
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'String hash converted', 'devMsg' => 'No msg', 'data' => $stringHash, 'redirect' => $hashString)));
    }
  }

  public function verifyLogin()
	{
    // print_r($this->request->getPost()); die('here in Ajax::register');
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $user_Email = $this->request->getPost('user_Email');
      $user_UserName = $this->request->getPost('user_Email');
      $user_PasswordEncrypt = $this->request->getPost('user_PasswordEncrypt');

      $dbResult = $this->CommonModel->verifyLogin($user_Email, $user_UserName, $user_PasswordEncrypt);
      // print_r($dbResult); // look into this to get the actual error
      if($dbResult['code'] == 200)
      {
        // set session here for login
        $this->session->set('loginUserData',$dbResult['userData'][0]);
        // print_r($dbResult['userData'][0]); print_r($this->session);
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'].' Redirecting, please wait.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => 'location.reload(true);')));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => $dbResult['msg'], 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Login incorrect. Please refresh the page and try again.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }
  
    /*
     * Start Single Sign-On Work (SSO)
     */
    public function autoLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $user_Email = $_REQUEST['email'];
            $findUserSql = "SELECT * FROM game_users WHERE user_Email = '$user_Email'";
            $dbResult = $this->CommonModel->executeQuery($findUserSql);
            if ($dbResult['code'] == 200) {
                $this->session->set('loginUserData', $dbResult['userData'][0]);
                echo '<script>window.location.href="http://localhost/b2c/"</script>';
                die;
            }
        }
    }
    /*
     * End Single Sign-On Work
     */ 
  
  public function forget_password()
	{
    $user_Email = $this->request->getPost('user_Email');
    if(!empty($user_Email))
    {
      $findUserSql = "SELECT * FROM game_users WHERE user_Email = '$user_Email'";
      $userData = $this->CommonModel->executeQuery($findUserSql);
      // print_r($userData);
      if($userData['code'] == 200)
      {
        $userData = $userData['userData'][0];
        // prd($userData);
        $updatePasswordRequestSql = "UPDATE game_users SET user_PasswordRequest=1 WHERE user_Id=$userData->user_Id";
        $updatePasswordRequest = $this->CommonModel->executeQuery($updatePasswordRequestSql);
        // send email with password reset link
        // $mail = SendMail($user_Email,'Get the following details to login to your account.','Requested Password',$this);
        $this->sendEmail->setTo($user_Email);
        $this->sendEmail->setFrom('contact@simulessons.com', 'Simulessons');
        $this->sendEmail->setMessage("Hi $userData->user_Fname, <br><br> You can login to your account using the below details.<br><br> <b>Username</b>: $userData->user_UserName<br> <b>Password</b>: $userData->user_Password<br><br>Regards,<br>Administrator");
        $this->sendEmail->setSubject("Password Request");
        $this->sendEmail->setAltMessage("this is alternate message for mailing");
        
        // pr($this->sendEmail); // prd($this->sendEmail->send());


        if($this->sendEmail->send())
        {
          die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Password Reset Email Sent To Your Email ID. Please also check in spam folder.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => 'location.reload(true);')));
        }
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Email not sent. Please Try Later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $this->sendEmail->printDebugger())));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => $userData['msg'], 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $userData['msg'])));
      }
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Email ID Is Requred.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => 'No user found')));
    }
  }
  
  // public function fetchGameCatalogue()
  // {
  //   // find the game which are available for b2c and user does not already have them
  //   $gameSql = "SELECT gg.* FROM GAME_GAME gg LEFT JOIN user_cart guc ON guc.cart_UserId = $this->userId AND guc.cart_GameId = gg.Game_ID WHERE gg.Game_ID NOT IN( SELECT gug.UG_GameID FROM GAME_USERGAMES gug WHERE gug.UG_UserID = $this->userId AND gug.UG_GameEndDate > NOW()) AND gg.Game_Status = 1 AND Game_Delete = 0 AND guc.GUC_ID IS NULL ORDER BY gg.Game_Name";
  //   $dbResult = $this->CommonModel->executeQuery($gameSql);

  //   // fetching the game count of the user cart
  //   $gameInCart = $this->CommonModel->executeQuery("SELECT * FROM user_cart guc WHERE guc.cart_UserId = $this->userId");
  //   $gameCountInCart = count($gameInCart);

  //   if(count($dbResult)>0)
  //   {
  //     die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2000, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game fetched successfylly.', 'devMsg' => 'No msg', 'data' => $dbResult, 'redirect' => '', 'gameCountInCart' => $gameCountInCart)));
  //   }
  //   else
  //   {
  //     die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No game available, or you already added all games to your cart', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gameCountInCart' => $gameCountInCart)));
  //   }
  // }

  public function addGameToCart($gameid=NULL)
  {
    if(!empty($gameid) && !empty($this->userId))
    {
      $insertArray = array(
        'cart_UserId' => $this->userId,
        'cart_GameId' => $gameid
      );
      // print_r($this->session->get('loginUserData')); die($cartSql);
      $dbResult = $this->CommonModel->insertRecordWithoutCheck('user_cart', $insertArray);
      // print_r($dbResult);
      // find the game which are available for b2c and user does not already have them
      if($dbResult['code'] == 201)
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Something went wrong. Please try later', 'devMsg' => $dbResult['msg'], 'data' => '', 'redirect' => '')));
      }
      else
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Item added to Cart successfully. You may continue purchasing or click on Cart to continue.', 'devMsg' => 'No msg', 'data' => $dbResult, 'redirect' => '')));
      }
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No game selected. Please refresh and try later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => 'location.reload(true);')));
    }
  }

  public function fetchCartGame()
  {
    // find the game which are available for b2c and user does not already have them
    $gameSql = "SELECT guc.GUC_Cart_Date, guc.GUC_ID, gg.* FROM user_cart guc LEFT JOIN GAME_GAME gg ON gg.Game_ID = guc.cart_GameId WHERE guc.cart_UserId = $this->userId";
    $dbResult = $this->CommonModel->executeQuery($gameSql);

    // fetching the game count of the user cart
    $gameInCart = $this->CommonModel->executeQuery("SELECT * FROM user_cart guc WHERE guc.cart_UserId = $this->userId");
    $gameCountInCart = count($gameInCart);

    if(count($dbResult)>0)
    {
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2000, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Your cart is ready.', 'devMsg' => 'No msg', 'data' => $dbResult, 'redirect' => '', 'gameCountInCart' => $gameCountInCart)));
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'You have not added anything to your cart.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gameCountInCart' => $gameCountInCart)));
    }
  }

  public function purchaseGame($gameid=NULL)
  {
    if(!empty($gameid))
    {
      // start purchase process
      // do the needful / write your code here
      // end of purchase process

      // if game purchase is successfull, then only do the following, so put it in if condition, skipping for now
      // step 1- insert the required into game_purchase table
      // step 2- then delete that record from user_cart table

      $cartSql = "DELETE FROM user_cart WHERE cart_UserId=$this->userId AND cart_GameId=$gameid";
      $dbResult = $this->CommonModel->executeQuery($cartSql);
      
      $insertArray = array(
        'purchase_userId' => $this->userId,
        'purchase_gameId' => $gameid,
        'purchase_transactionId' => mt_rand(),
        'purchase_gameStartDate' => date('Y-m-d H:i:s'),
        'purchase_gameEndDate' => date('Y-m-d H:i:s'),
      );
      $purchaseSql = $this->CommonModel->insertRecordWithoutCheck('game_purchase', $insertArray);
      
      // remaining cart games
      $fetchCartSql = "SELECT * FROM user_cart WHERE cart_UserId=$this->userId";
      $cartResult = $this->CommonModel->executeQuery($fetchCartSql);
      $gameids = array();
      // print_r($cartResult);
      if(count($cartResult)>0)
      {
        foreach($cartResult['userData'] as $cartResultRow)
        {
          $gameids[] = $cartResultRow->cart_GameId;
        }
      }
      
      // die(' creating user data ');
      // find the game which are available for b2c and user does not already have them
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game purchased successfully.', 'devMsg' => 'No msg', 'data' => implode(',',$gameids), 'redirect' => '')));
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No game selected. Please refresh and try later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }

  public function removeGameFromCart($gameid=NULL)
  {
    if(empty($gameid))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No game selected. Please refresh and try later.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      $sqlCart = "DELETE FROM user_cart WHERE cart_UserId=$this->userId AND cart_GameId=$gameid ";
      $removeCart = $this->CommonModel->executeQuery($sqlCart);
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game removed from cart', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }
  
  public function gamePurchased()
  {
    // print_r($this->request->getPost());
    $txnStatus = $this->request->getPost('txnStatus');
    $txnid = $this->request->getPost('txnid');
    $MerTxnId = $this->request->getPost('MerTxnId');
    $userid = $this->request->getPost('userid');
    $gameIds = $this->request->getPost('gameIds');

    $checkSql = "SELECT * FROM payment_transaction WHERE pay_userId=$userid AND pay_txnId='".$txnid."' AND pay_merchantTxnId='".$MerTxnId."' AND pay_taskPerformed = 0";
    $checkRes = $this->CommonModel->executeQuery($checkSql);
    // print_r($checkRes); exit();
    
    // remove game from cart and put in the purchase table
    $cartSql = "DELETE FROM user_cart WHERE cart_UserId=$userid AND cart_GameId IN($gameIds)";
    $clearCart = $this->CommonModel->executeQuery($cartSql);

    if($checkRes['code'] == 200)
    {

      $gameIds = explode(',', $gameIds);
      for($g=0; $g<count($gameIds); $g++)
      {
        $insertArray = array(
          'purchase_userId' => $userid,
          'purchase_gameId' => $gameIds[$g],
          // 'purchase_transactionId' => mt_rand(),
          // 'purchase_gameStartDate' => date('Y-m-d H:i:s'),
          // 'purchase_gameEndDate' => date('Y-m-d H:i:s'),
        );
        $purchaseSql = $this->CommonModel->insertRecordWithoutCheck('game_purchase', $insertArray);
      }
      $changeStatus = $this->CommonModel->executeQuery("UPDATE payment_transaction SET pay_taskPerformed = 1 WHERE pay_id = ".$checkRes['userData'][0]->pay_id);
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game Purchased Successfully', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'User already cretaed and game allocated.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }

  public function resetpassword()
  {
    // print_r($_POST); // user_Password oldPassword newPassword newPasswordConfirm
    $oldPassword = $this->request->getPost('oldPassword');
    $newPassword = $this->request->getPost('newPassword');
    $newPasswordConfirm = $this->request->getPost('newPasswordConfirm');
    $this->validation->setRules([
      'oldPassword' => [
        'label' => 'Old Password',
        'rules' => 'required',
        'errors' => ['alpha' => 'The First Name field may only contain alphabetical characters.'],
      ],
      'newPassword' => [
        'label' => 'New Password',
        'rules' => 'required|min_length[5]',
        'errors' => ['alpha' => 'The First Name field may only contain alphabetical characters.'],
      ],
      'newPasswordConfirm' => [
        'label' => 'Confirm Password',
        'rules' => 'required|min_length[5]|matches[newPassword]',
        'errors' => [
          'alpha' => 'The First Name field may only contain alphabetical characters.',
          // 'matches' => 'New Password does not match with Confirm Password field',
        ],
      ],
    ]);

    // validation ends here
    $validate = $this->validation->withRequest($this->request)->run();
    // var_dump($this->validation->withRequest($this->request)->run());
    $errors = $this->validation->getErrors();
    // show errors here and die, if no error then go ahead
    // print_r($errors); print_r($this->validation); die(' after error ');

    if($validate === false)
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There have been validation errors. Please check.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $errors)));
    }
    
    $checkSql = "SELECT * FROM game_users WHERE user_Id=$this->userId AND user_Password='".$oldPassword."'";
    $checkRes = $this->CommonModel->executeQuery($checkSql);
    // $checkRes['code'] $checkRes['msg']  print_r($checkRes); 
    if($checkRes['code'] == 200)
    {
      $updateSql = "SELECT * FROM game_users WHERE user_Id=$this->userId AND user_Password='".$oldPassword."'";
      $updateSql = "UPDATE game_users SET user_Password='".$newPassword."' , user_PasswordEncrypt='".md5($newPassword)."'";
      $updateRes = $this->CommonModel->executeQuery($updateSql);
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 2500, 'type' => 'success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Password changed successfully', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 2500, 'type' => 'error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Old/Current password is incorrect.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'errorMsg' => $checkRes['msg'])));
    }
  }
  
  /**
   * Add link to catalog items
   */
  public function addLinkToCatalogItem()
  {
    $link = $this->request->getPost('link');
    $gameID = $this->request->getPost('game_id');
    $target = $this->request->getPost('target');

    $response = array('success' => 0, 'message' => 'Something went wrong! Please try again later.');
    
    if( empty($link) && !empty($gameID) ) {
      $sql = "DELETE FROM `catalog_link` WHERE `game_id`=$gameID";
      $result = $this->CommonModel->executeQuery($sql);
      $response = array('success' => 1, 'message' => 'success');
      die(json_encode($response));
    }
    
    if (!empty($link) && !empty($gameID)) {
      $sql = "SELECT * FROM `catalog_link` WHERE `game_id`=$gameID";
      $result = $this->CommonModel->executeQuery($sql);

      if (!empty($result) && ($result['code'] == 200)) {
        $data = isset($result['userData']) && !empty($result['userData']) ? $result['userData'] : array();
        $linkPrev = isset($data[0]) ? $data[0]->link : '';
        $id = isset($data[0]) ? $data[0]->id : '';

        if ($linkPrev == $link)
          $response = array('success' => 0, 'message' => 'This link already exist.');
        else {
          $sql = "UPDATE `catalog_link` SET `link`='$link',`target`='$target' WHERE `game_id`=$gameID AND `id`=$id";
          $result = $this->CommonModel->executeQuery($sql);
          $response = array('success' => 1, 'message' => 'success');
        }
      } else {
        $sql = "INSERT INTO `catalog_link` (game_id,link,target) VALUES ($gameID, '$link','$target')";
        $result = $this->CommonModel->executeQuery($sql);
        $response = array('success' => 1, 'message' => 'success');
      }
    }

    die(json_encode($response));
  }

  /**
   * Add link to catalog items
   */
  public function updateLinkToCatalogItem()
  {
    $link = $this->request->getPost('link');
    $gameID = $this->request->getPost('game_id');
    $target = $this->request->getPost('target');

    $response = array('success' => 0, 'message' => 'Something went wrong! Please try again later.');

    if (!empty($link) && !empty($gameID)) {
      $sql = "UPDATE `catalog_link` SET `link`='$link',`target`='$target' WHERE `game_id`=$gameID";
      $result = $this->CommonModel->executeQuery($sql);
      $response = array('success' => 1, 'message' => 'success');
    }

    die(json_encode($response));
  }

  /**
   * Delete added link
   */
  public function deleteLinkToCatalogItem()
  {
    $gameID = $this->request->getPost('game_id');
    $response = array('success' => 0, 'message' => 'Something went wrong! Please try again later.');

    if (!empty($gameID)) {
      $sql = "DELETE FROM `catalog_link` WHERE `game_id`=$gameID";
      $result = $this->CommonModel->executeQuery($sql);
      $response = array('success' => 1, 'message' => 'success');
    }

    die(json_encode($response));
  }

  public function getGameLinks()
  {
    $gameIDs = $this->request->getPost('game_id');
    $response = array('success' => 0, 'message' => 'Something went wrong! Please try again later.');

    if (!empty($gameIDs)) {
      $linksList = array();
      $sql = "SELECT `game_id`,`link`, `target` FROM `catalog_link` WHERE `game_id` IN($gameIDs)";
      $result = $this->CommonModel->executeQuery($sql);

      if (!empty($result) && ($result['code'] == 200)) {
        $data = isset($result['userData']) && !empty($result['userData']) ? $result['userData'] : array();

        // Get the loggedin user details
        $user  = $this->session->get('loginUserData');
        $userEmail = isset($user->user_Email) ? $user->user_Email : '';
        $userPassword = isset($user->user_Password) ? $user->user_Password : '';

        $linkURL = '';
        if (!empty($userEmail) && !empty($userPassword))
          $linkURL = "https://simulessons.com/trgroi2/auto-login?user_Email=" . $userEmail . "&user_Password=" . $userPassword;


        $linksList = array();
        foreach ($data as $val) {
          $link = !empty($val) && isset($val->link) && !empty($val->link) ? $val->link : '';

          $linksList[$val->game_id] = array(
            'link_ori' => $link,
            'link' => !empty($linkURL) ? $linkURL . "&url=" . $link : $link,
            'target' =>  isset($val->target) && !empty($val->target) ? $val->target : '_blank'
          );
        }
        $response = array('success' => 1, 'links' =>  $linksList);
      }
    }

    die(json_encode($response));
  }

}
