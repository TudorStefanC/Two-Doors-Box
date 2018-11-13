<!doctype html>
<html lang="en">
 <?php 
  require "includes/tools.php";

    session_start();
    

//    $user=getUserInfo($email);
//    $user["username"]
    if (!isset($_SESSION['email'])){
        header("refresh:0.5;url=index.php");
        exit();

    }else{
         $email=$_SESSION["email"];
         $username=$_SESSION["username"];
  ?>
                        
  <head>
    <title>TwoDoorsBox</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
  </head>
  <body>
    <body>
 <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
     <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="img/double-door.svg" width="30" height="30" class="d-inline-block align-top" alt="TwoDoorsBox">
          TwoDoorsBox
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
       <div class="dropdown">
            <a href="#" data-toggle="dropdown">
             <?php       
              echo $username;
              ?>
              <img src="img/account.svg" width="30" height="30" class="d-inline-block align-top" alt="User Account">
              </a>
              <div class="dropdown-menu dropdown-menu-left">
              <a class="dropdown-item" href="space.php">Available space</a>
              <a class="dropdown-item" href="settings.php">Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="sign-out.php">Sign out</a>
              </div>
        </div>
      </div>
      </div>
  </nav> <!-- End of navbar -->

    <div class="container-fluid hero">
        <div class="row">
          <div class="col-sm-2 files">
           <aside>
            <nav class="nav flex-column">
              <a class="nav-link active" href="#">Home</a>
              <a class="nav-link" href="admin.php">My files</a>
            </nav>
            </aside>
          </div>
          <div class="col-sm-10"> 
            <section>
            
           
  
            <h3>Personal account</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>General settings</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Username</td>
                  <td><?php echo $username; ?></td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Edit</a></td>
                </tr>
                <tr>
                  <td>Personal e-mail</td>
                  <td><?php echo $email; ?></td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Edit</a></td>
                </tr>
                <tr>
                  <td>Change password</td>
                  <td></td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Edit</a></td>
                </tr>
              </tbody>
            </table>
            <hr>
            </section>
          </div> 
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    
    <?php 
    }
    ?>
  </body>
</html>