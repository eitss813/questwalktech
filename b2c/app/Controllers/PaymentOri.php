<?php 
namespace App\Controllers;

class Payment extends BaseController
{
  protected $CommonModel;
	public function __construct()
	{
		parent::__construct();
    $this->CommonModel = new \App\Models\CommonModel();
    // echo "<pre>"; print_r($this->session->get('loginUserData')); die(' here ');
		// if($this->session->get('loginUserData') == NULL){
    //   header('Location: '.base_url());
    //   exit();
    // }
  }
	
	
	public function index()
	{
    echo hash('sha512','MHzJ4L|123456|10|irecruitGame|Mohit|mksahu23506@gmail.com|||||||||||IBJCZsht');
    die('<br>testhere<br>');
    // echo "<pre>"; print_r($this->session->getFlashdata());
    $this->session->setFlashdata('error', 'Not a valid URL.');
    // $this->session->setFlashdata('success', 'test success method');
    header('Location: '.base_url('Catalogue'));
    exit();
  }

  public function success($arg=NULL)
  {
    $uid = $this->session->get('loginUserData')->user_Id;
    // show this page when payement is made successfully
    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    if($RequestMethod == 'POST')
    {
      // echo "<pre>$arg<br>".trim(base64_decode($arg),',')."<br>"; print_r($_POST); exit();
      // txnStatus txnid MerTxnId // $_POST['status'] $_POST['txnid'] $_POST['mihpayid']
      $contant['imgUrl'] =  'writable/uploads/payment_success.png';
      $contant['subview'] =  'success';
      $contant['gameIds'] =  trim(base64_decode($arg),',');
      $contant['postData'] =  "txnStatus=".$_POST['status']."&txnid=".$_POST['txnid']."&MerTxnId=".$_POST['mihpayid']."&userid=".$uid."&gameIds=".trim(base64_decode($arg),',');
      // insert record into payment_transaction table before anything
      $checkSql = "SELECT * FROM payment_transaction WHERE pay_userId=$uid AND pay_txnId='".$_POST['txnid']."' AND pay_merchantTxnId='".$_POST['mihpayid']."'";
      $checkRes = $this->CommonModel->executeQuery($checkSql);
      // echo "<pre>"; print_r($checkRes); exit();
      if($checkRes['code'] == 201)
      {
        // no record found so insert the record into the database table
        $TxnArray = array(
          'pay_userId' => $uid,
          'pay_txnId' => $_POST['txnid'],
          'pay_merchantTxnId' => $_POST['mihpayid'],
          'pay_paymentData' => json_encode($_POST),
        );
        $insertTxn = $this->CommonModel->insertRecordWithoutCheck('payment_transaction', $TxnArray);
      }

      return view('main_layout',$contant);
    }
    else
    {
      die('You are not allowed to visit this page');
    }
  }

  public function cancel($arg=NULL)
  {
    // show this page when payement is canceled
    $uid = $this->session->get('loginUserData')->user_Id;
    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    if($RequestMethod == 'POST')
    {
      $TxnArray = array(
        'pay_userId' => $uid,
        'pay_txnId' => $_POST['txnid'],
        'pay_merchantTxnId' => $_POST['mihpayid'],
        'pay_paymentData' => json_encode($_POST),
      );
      $insertTxn = $this->CommonModel->insertRecordWithoutCheck('payment_transaction', $TxnArray);
      $contant['subview'] =  'cancel';
      return view('main_layout',$contant);
    }
    else
    {
      die('You are not allowed to visit this page');
    }
  }

  public function freeGame($arg=NULL,$freeImg=NULL)
  {
    $uid = $this->session->get('loginUserData')->user_Id;
    // show this page when payement is made successfully
    // $RequestMethod = $_SERVER['REQUEST_METHOD'];
    if(!empty($arg))
    {
      // echo "<pre>$arg<br>".trim(base64_decode($arg),',')."<br>"; print_r($_POST); exit();
      // txnStatus txnid MerTxnId // $_POST['status'] $_POST['txnid'] $_POST['mihpayid']
      $contant['imgUrl'] =  'writable/uploads/freePurchaseImg.jpg';
      $contant['subview'] =  'success';
      $contant['gameIds'] =  trim(base64_decode($arg),',');
      $contant['postData'] =  "txnStatus=success&txnid=free&MerTxnId=free".$arg."&userid=".$uid."&gameIds=".trim(base64_decode($arg),',');
      // insert record into payment_transaction table before anything
      $checkSql = "SELECT * FROM payment_transaction WHERE pay_userId=$uid AND pay_txnId='free' AND pay_merchantTxnId='free".$arg."'";
      $checkRes = $this->CommonModel->executeQuery($checkSql);
      // echo "<pre>"; print_r($checkRes); exit();
      if($checkRes['code'] == 201)
      {
        // no record found so insert the record into the database table
        $TxnArray = array(
          'pay_userId' => $uid,
          'pay_txnId' => 'free',
          'pay_merchantTxnId' => "free".$arg,
          'pay_paymentData' => "Purchased free game: ".trim(base64_decode($arg),','),
        );
        $insertTxn = $this->CommonModel->insertRecordWithoutCheck('payment_transaction', $TxnArray);
      }

      return view('main_layout',$contant);
    }
    else
    {
      die('You are not allowed to visit this page');
    }
  }

  public function fail($arg=NULL)
  {
    // show this page when payement is failed
    $uid = $this->session->get('loginUserData')->user_Id;
    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    if($RequestMethod == 'POST')
    {
      $TxnArray = array(
        'pay_userId' => $uid,
        'pay_txnId' => $_POST['txnid'],
        'pay_merchantTxnId' => $_POST['mihpayid'],
        'pay_paymentData' => json_encode($_POST),
      );
      $insertTxn = $this->CommonModel->insertRecordWithoutCheck('payment_transaction', $TxnArray);
      $contant['subview'] =  'fail';
      return view('main_layout',$contant);
    }
    else
    {
      die('You are not allowed to visit this page');
    }
  }
    
}
