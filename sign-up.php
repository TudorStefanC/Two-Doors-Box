<!doctype html>
<html lang="en">
  <head>
    <title>Sign-up to TwoDoorsBox</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-inverse bg-light">
     <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="img/double-door.svg" width="30" height="30" class="d-inline-block align-top" alt="TwoDoorsBox">
          TwoDoorsBox
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      </div>
    </nav>
    <section class="sign-up">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 text-center">
            <img src="img/sign-up.svg" class="pictogram" alt="Sign-in Pictogram">
          </div>
          <div class="col-sm-5">
            <form action="includes/register.php" method="post">
              <div class="form-group">
              <label for="InputUser">Username</label>
              <input type="username" name="username" class="form-control" id="InputUser" placeholder="Enter Username" required>
              </div>
              <div class="form-group">
              <label for="InputEmail">Email address</label>
              <input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter Email" required>
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
              </div>
              <div class="form-group">
              <label for="InputPassword">Password</label>
              <input type="password" name="password" class="form-control" id="InputPassword" placeholder="Enter Password" required>
              </div>
              
              <button type="submit" class="btn btn-primary">Sign up</button>
            </form>
          </div>
        </div> <!-- End of row -->
      </div> <!-- End of container -->
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>