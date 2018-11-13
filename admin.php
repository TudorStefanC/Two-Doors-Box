<!doctype html>
<html lang="en">
 <?php 
  require "includes/tools.php";

    session_start();
    

//    $user=getUserInfo($email);
//    $user["username"]
    if (!isset($_SESSION['email'])){
        header("refresh:0.2;url=index.php");
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
              <a class="nav-link " href="#">Home</a>
              <a class="nav-link active" href="admin.php">My files</a>
            </nav>
            </aside>
          </div>
          <div class="col-sm-8"> 
            <section>
              <h3>TwoDoorsBox</h3>
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Last modified</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><img src="img/folder.svg" width="30" height="30" class="d-inline-block align-top folder-padding" alt="Folder">Folder1</td>
                  <td></td>
                  <td>
                  <!--Dropdown menu for folder actions -->
                  <div class="dropdown">
                  <a href="#" data-toggle="dropdown"><img src="img/three-dot.svg" width="30" height="30" class="d-inline-block align-top img-hover" alt="Edit"></a>
                    <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="download.php">Download</a>
                    <a class="dropdown-item" href="rename.php">Rename</a>
                    <a class="dropdown-item" href="delete.php">Delete</a>
                    </div>
                  </div>
                  <!-- End of Dropdown menu for folder actions -->
                  </td>
                </tr>
                <tr>
                  <td><img src="img/folder.svg" width="30" height="30" class="d-inline-block align-top folder-padding" alt="Folder">Folder2</td>
                  <td></td>
                  <td><!--Dropdown menu for folder actions -->
                  <div class="dropdown">
                  <a href="#" data-toggle="dropdown"><img src="img/three-dot.svg" width="30" height="30" class="d-inline-block align-top img-hover" alt="Edit"></a>
                    <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="download.php">Download</a>
                    <a class="dropdown-item" href="rename.php">Rename</a>
                    <a class="dropdown-item" href="delete.php">Delete</a>
                    </div>
                  </div>
                  <!-- End of Dropdown menu for folder actions --></td>
                </tr>
                <tr>
                  <td><img src="img/folder.svg" width="30" height="30" class="d-inline-block align-top folder-padding" alt="Folder">Folder3</td>
                  <td></td>
                  <td><!--Dropdown menu for folder actions -->
                  <div class="dropdown">
                    <a href="#" class="" data-toggle="dropdown"><img src="img/three-dot.svg" width="30" height="30" class="d-inline-block align-top img-hover" alt="Edit"></a>
                    <div class="dropdown-menu dropdown-menu-left">
                    <a class="dropdown-item" href="download.php">Download</a>
                    <a class="dropdown-item" href="rename.php">Rename</a>
                    <a class="dropdown-item" href="delete.php">Delete</a>
                    </div>
                  </div>
                  <!-- End of Dropdown menu for folder actions --></td>
                </tr>
              </tbody>
            </table>
            <hr>
            </section>
          </div> 
          <div class="col-sm-2 right-section">
            <a href="/includes/upload.php" class="btn btn-outline-primary btn-block">Upload files</a>
            <a href="new-folder.php" class="btn btn-primary btn-block">New folder</a>
          </div>
        </div> <!-- End of row -->
    </div> <!-- End of container-fluid -->
    
    
    
<form action="includes/upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
        
        
        
        <?php
        

        
    /*==================================================*/
	/*Get folder content*/
	/*==================================================*/
	function getFolderContent(){

		$folderPath="includes/uploads/";
		$folderContent = scandir($folderPath);


		$html="";

		$checkBoxDefaultStart="<div class='styled-input--diamond'><div class='styled-input-single'>";
        $checkBoxDefaultEnd="</div></div>";
    

		for($i=2;$i<sizeof($folderContent);$i++){

			$file=$folderContent[$i];
			$itemBoxHtml="";

			if(is_dir($folderPath.$file)){
				$image="<img src='images/folder_icon.svg' class='folderIcon' alt='".$folderContent[$i]."'>";

				$itemSelectBox="<input type='checkbox' id='".$folderContent[$i]."' class='checkboxItemSelector folderFileItem' name='itemSelector' value='".$folderContent[$i]."'>";
				$itemSelectBox=$itemSelectBox."<label for='".$folderContent[$i]."'></label>";
				$itemSelectBox=$checkBoxDefaultStart.$itemSelectBox.$checkBoxDefaultEnd;

				$objectHtml="<div for='".$folderContent[$i]."' class='subFolderLink'>".$image."<p>".$folderContent[$i]."</p></div>";
				$itemBoxHtml="<div class='folderObjectBox'>".$objectHtml.$itemSelectBox."</div>";
			}else{
				$image="<img src='images/image_file_icon.svg' class='fileIcon' alt='".$folderContent[$i]."'>";

				$itemSelectBox="<input type='checkbox' id='".$folderContent[$i]."' class='checkboxItemSelector objectFileItem' name='itemSelector' value='".$folderContent[$i]."'>";
				$itemSelectBox=$itemSelectBox."<label for='".$folderContent[$i]."'></label>";
				$itemSelectBox=$checkBoxDefaultStart.$itemSelectBox.$checkBoxDefaultEnd;

				$objectHtml="<div data-filename='".$folderContent[$i]."' class='folderItem' data-filepath='".$file."'>".$image."<p>".$folderContent[$i]."</p></div>";
				$itemBoxHtml="<div class='folderObjectBox'>".$objectHtml.$itemSelectBox."</div>";
			}

			$html=$html.$itemBoxHtml;

		}
		
		//echo $html;
      return $html;
	}    
        
       echo getFolderContent();
        
        
        ?>
        
        
        
        
					
					

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