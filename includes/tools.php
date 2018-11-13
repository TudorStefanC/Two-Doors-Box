<?php
  require "medoo.php";
  use Medoo\Medoo;


  function getDb(){
    $database = new Medoo([
        // required
        'database_type' => 'mysql',
        'database_name' => 'mydb',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
    ]);
    return $database;
  }
  function getUser($id){
     $db=getDB();
              $result = $db->select("users", [
	     "username",
	     "email"
          ], [
	     "id[=]" => $id
              ]);
    return $result[0];
  }
    /*+++++++++++++++++++++++++++++++++*/
	/*User login*/
	/*+++++++++++++++++++++++++++++++++*/
  function userLogin($email, $password){
    if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
    $db=getDB();
    $result = $db->select("users", [
	     "username",
	     "email"
          ], [
	     "email[=]" => $email,
          "password[=]" => $password
              ]);
    if(sizeof($result)==0){
      return NULL;
    }
    return $result[0];
    
  }

    /*+++++++++++++++++++++++++++++++++*/
	/*User logout*/
	/*+++++++++++++++++++++++++++++++++*/
	function userLogout(){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
		session_unset();
		session_destroy(); 

		unset($_COOKIE['PHPSESSID']);
    }





?>
