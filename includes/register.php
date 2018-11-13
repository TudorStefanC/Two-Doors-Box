<?php

  require "tools.php";

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $database=getDb();

  $database->insert("users", [
      "username" => $username,
      "email" => $email,
      "password" => $password
  ]);




?>
