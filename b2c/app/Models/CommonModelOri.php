<?php 
namespace App\Models;

use CodeIgniter\Model;
$db = \Config\Database::connect();


class CommonModel extends Model
{
  public function test()
  {
    // echo "<pre>"; print_r($this->db); echo 'in model';
    // $query = $this->db->query("SELECT * FROM MYTABLE");
    try
    {
      if($this->db->query("SELECT * FROM GAME_OUTPUT"))
      {
        print_r($this->db->query("SELECT * FROM GAME_OUTPUT")->getResult());
        echo 'query exe';
      }
      else
      {
        echo 'wrong query';
      }
    }
    catch (\Exception $e)
    {
      die($e->getMessage());
    }
  }
  
  private function checkQueryBeforeExecute($query=NULL)
  {
    try
    {
      $result = $this->db->query($query)->getResult();
      // return $result;
      if(count($result)>0)
      {
        return array('code'=> 200, 'msg'=> 'Data fetched successfully', 'userData' => $result);
      }
      else
      {
        return array('code'=> 201, 'msg'=> 'No record found. Pleae try with different details', 'userData' => $result);
      }
    }
    catch (\Exception $e)
    {
      // return $e->getMessage();
      return array('code'=> 201, 'msg'=> $e->getMessage(), 'userData' => '');
    }
  }

  public function executeQuery($sqlQuery=NULL)
  {
    // echo 'run query fetch object';
    $result = $this->checkQueryBeforeExecute($sqlQuery);
    return $result;
  }

  public function register($usersArray=NULL, $whereArray=NULL)
  {
    // $result = $this->checkQueryBeforeExecute($sqlQuery);
    $builder = $this->db->table('game_users');
    // $builder->select();
    $builder->orWhere($whereArray);
    $sqlQuery = $builder->getCompiledSelect();
    $result = $this->checkQueryBeforeExecute($sqlQuery);
    // echo $builder->getCompiledSelect(); // this gives the last query
    // print_r($usersArray); print_r($whereArray); print_r($result); echo count($result).'<br>';
    if($result['code'] = 201)
    {
      $builder->insert($usersArray);
      $insert_id = $this->db->insertID();
      // echo $insert_id.' and '.$insert_password;
      return array('code'=> 200, 'msg'=> 'Registration Successfull.');
    }
    else
    {
      // duplicate record, as this record already exist
      return array('code'=> 201, 'msg'=> $result['msg']);
    }
  }

  // public function insertRecordInMultipleTablesWithoutCheck($tableNameArray=NULL, $insertDataArray=NULL)
  // {
  //   // echo 'insert multiple record without check';
  //   // add transactions
  //   for($i=0; $i<=count($tableNameArray); $i++)
  //   {
  //     $builder = $this->db->table($tableName[$i]);
  //     try
  //     {
  //       $result = $builder->insert($insertArray[$i]);
  //       return $result;
  //     }
  //     catch (\Exception $e)
  //     {
  //       return $e->getMessage();
  //     }
  //   }
  // }

  // public function insertRecordInMultipleTablesWithCheck($tableNameArray=NULL, $insertDataArray=NULL, $checkExistingArray=NULL)
  // {
  //   // echo 'insert multiple record with check';
  //   // add transactions
  //   for($i=0; $i<=count($tableNameArray); $i++)
  //   {
  //     $builder = $this->db->table($tableName[$i]);
  //     try
  //     {
  //       $result = $builder->insert($insertArray[$i]);
  //       return $result;
  //     }
  //     catch (\Exception $e)
  //     {
  //       return $e->getMessage();
  //     }
  //   }
  // }

  public function insertRecordWithoutCheck($tableName=NULL, $insertArray=NULL)
  {
    // echo 'insert record without check';
    $builder = $this->db->table($tableName);
    try
    {
      $result = $builder->insert($insertArray);
      // return $result;
      return array('code'=> 200, 'msg'=> 'Record Inserted Successfully.', 'insertedData' => $result);
    }
    catch (\Exception $e)
    {
      // return $e->getMessage();
      return array('code'=> 201, 'msg'=> $e->getMessage(), 'userData' => '');
    }
  }

  public function insertRecordWithCheck($tableName=NULL, $insertArray=NULL, $checkExisting=NULL)
  {
    // echo 'insert record with check existing record, to prevent duplicate record';
    $result = $this->checkQueryBeforeExecute($sqlQuery);
    return $result;
  }

  public function verifyLogin($user_Email=NULL, $user_UserName=NULL, $user_PasswordEncrypt=NULL)
  {
    try
    {
      // echo 'verifying login for users';
      $builder = $this->db->table('game_users');
      $builder->groupStart();
      $builder->orWhere(array('user_Email'=>$user_Email, 'user_UserName'=>$user_UserName));
      $builder->groupEnd();
      $builder->where(array('user_PasswordEncrypt'=>md5($user_PasswordEncrypt)));
      $sqlQuery = $builder->getCompiledSelect();
      $userResult = $this->checkQueryBeforeExecute($sqlQuery);
      // echo $sqlQuery."<br>"; print_r($userResult);
      return $userResult;
    }
    catch(\Exception $e)
    {
      // print_r($e); die($e->getMessage());
      return array('code'=> 201, 'msg'=> $e->getMessage(), 'error' => $e);
    }
  }

  public function updateRecord($tableName=NULL, $where=NULL)
  {
    // echo "updating record";
    $result = $this->checkQueryBeforeExecute($sqlQuery);
    return $result;
  }

  public function deleteRecord($tableName=NULL, $where=NULL)
  {
    // echo "deleting record permanently";
    $result = $this->checkQueryBeforeExecute($sqlQuery);
    return $result;
  }
}