<?php

  require "tools.php";

  $email = $_POST["email"];
  $password = $_POST["password"];

  $user = userLogin($email, $password);

  if(is_null($user)){
  ?>
  
  <script>alert("Your email/password is incorrect! Please try again");
  window.location="../sign-in.php";
  </script>
  <?php
    
  } else {
    session_set_cookie_params(10*24*60*60); //session-cookie set for 10 days
if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
    $_SESSION["email"] = $user["email"];
    $_SESSION["username"] = $user["username"]; 
    }

    header("refresh:0.5;url=../admin.php");
    exit();


?>
