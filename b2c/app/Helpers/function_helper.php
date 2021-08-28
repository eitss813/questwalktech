<?php

use App\Models\Common_Model;


function prd($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die;
}


function pr($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function SendMail($toEmail,$html,$subject,$ci)
{
  $mail = \Config\Services::email();
  // $mail->SMTPUser    = 'contact@simulessons.com';
  // $mail->SMTPPass    = 'richie11**';
  $mail->setFrom('contact@simulessons.com', 'Simulessons');
  $mail->setTo($toEmail);
  $mail->setMessage($html);
  $mail->setSubject($subject);
  $mail->setAltMessage('This is the alternative message');
  if($mail->send())
  {
    return 200;
  }
  else
  { 
    return json_encode($mail->printDebugger());
  }
}

function do_upload($CI){

  $config['upload_path']   = './common/profilePic/';
  $config['allowed_types'] = 'gif|jpeg|jpg|png';
  $config['max_size']      = 1024;
  if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");

  $CI->load->library('upload', $config);
  $CI->upload->initialize($config);

  if (!$CI->upload->do_upload('Users_ProfilePic') && !$CI->upload->do_upload('Users_SiteLogo'))
  { 
    $error = array('error' => $CI->upload->display_errors());
    echo $CI->upload->display_errors();
  }
  else
  {
    $data = array('upload_data' => $CI->upload->data());
    $data['upload_data']['file_name'] = str_replace(' ', '_', $data['upload_data']['file_name']);
    $updateSessionData['Users_ProfilePic'] = $data['upload_data']['file_name'];
  } 
}

function gen_uuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}

function AdminMail(){

  $where = array('EntityType' => -1);

  $obj = new Common_Model();
  $result = $obj->fetchRecords('entity',$where,NULL,'EntityEmail');
  
  if(!empty($result))
  {
    // return $result[0]->EntityEmail;
    return 'sajal@digialaya.com';
  }
  else
  {
    return '';
  }
}


function SendContactMail($toEmail,$html,$subject,$ci)
{
  $mail = \Config\Services::email();

  $mail->SMTPUser    = 'contact@yudlee.com';
  $mail->SMTPPass    = 'Yudlee@123';
  $mail->setFrom('Yudlee', 'Yudlee');
  $mail->setTo($toEmail);
  $mail->setSubject($subject);
  $mail->setMessage($html);


  if($mail->send())
  {
    $result = 'success';
    return json_encode($result);
  }
  else
  { 
   // var_dump($mail->printDebugger(['headres'])); exit();
    $result = 'error';
    return json_encode($result);
  }
}

?>