<?php
  require "includes/tools.php";

  userLogout();

  header("refresh:0.2;url=sign-in.php");
  exit();


?>