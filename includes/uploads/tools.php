<?php
	/*==================================================*/
	/*Libraries*/
	/*==================================================*/
	require 'development.php';
	require 'default_values.php';
	require 'Medoo.php';
	use Medoo\Medoo;
	/*==================================================*/
	/*Database operations*/
	/*==================================================*/
	function getDB() {
		$db = new Medoo(array(
			'database_type' => 'mysql',
			'database_name' => 'mydb',
			'server' => 'localhost',
			'username' => 'root',
			'password' => ''
		));
		return $db;
	}
	/*==================================================*/
	/*Get a random string*/
	/*==================================================*/
	function randomKey($text) { 
		return "".md5(rand(0,100)."".$text."".rand(0,100)."".time()."".rand(0,100)); 
	}
	/*==================================================*/
	/*Check if the user is logged in*/
	/*==================================================*/
	function checkLogin(){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}

		global $SESSION_KEY_COOKIE_NAME;
		global $LOGGED_EMAIL_COOKIE_NAME;

		if(!isset($_SESSION[$SESSION_KEY_COOKIE_NAME])
			||!isset($_SESSION[$LOGGED_EMAIL_COOKIE_NAME])) {
			return false;
		} else {
			$db = getDB();
			$users = $db->select('users', array('ID','NAME','SURNAME','EMAIL'), [
				"AND" => ["email" => $_SESSION[$LOGGED_EMAIL_COOKIE_NAME],
				"session_key" => $_SESSION[$SESSION_KEY_COOKIE_NAME]]]);
			if(count($users)==1){
				return true;
			}else{
				return false;
			}
		}

	}
	/*==================================================*/
	/*Get logged user info*/
	/*==================================================*/
	function getUserInfo(){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
		global $SESSION_KEY_COOKIE_NAME;
		global $LOGGED_EMAIL_COOKIE_NAME;
		if(checkLogin()){
			$db = getDB();
			$users = $db->select('users', array('ID','NAME','SURNAME','EMAIL','FOLDER'), [
				"AND" => ["email" => $_SESSION[$LOGGED_EMAIL_COOKIE_NAME],
				"session_key" => $_SESSION[$SESSION_KEY_COOKIE_NAME]]]);
			if(count($users)==1){
				return $users[0];
			}
		}
		return NULL;
	}
	/*==================================================*/
	/*User logout*/
	/*==================================================*/
	function userLogout(){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
		global $SESSION_KEY_COOKIE_NAME;
		global $LOGGED_EMAIL_COOKIE_NAME;
		if(checkLogin()){
			$loggedUserInfo=getUserInfo();
			$db = getDB();
			$statement = $db->update("users",
						["session_key" => NULL],
						["id"=>$loggedUserInfo["ID"]]);
			if($statement->rowCount()==1){
				destroySession();

				//$res = setcookie($SESSION_KEY_COOKIE_NAME, '', time() - 3600);
				//$res = setcookie($LOGGED_EMAIL_COOKIE_NAME, '', time() - 3600);
				if(!isset($_SESSION[$SESSION_KEY_COOKIE_NAME])
					&&!isset($_SESSION[$LOGGED_EMAIL_COOKIE_NAME])){
					return true;
				}
			}
			return false;
		}
		return true;
	}
	function destroySession(){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}
		session_unset();
		session_destroy(); 

		global $SESSION_KEY_COOKIE_NAME;
		global $LOGGED_EMAIL_COOKIE_NAME;

		unset($_SESSION[$SESSION_KEY_COOKIE_NAME]);
		unset($_SESSION[$LOGGED_EMAIL_COOKIE_NAME]);
		unset($_COOKIE['PHPSESSID']);
    }

	/*==================================================*/
	/*Create user folder*/
	/*==================================================*/
	function createFolder($folder_name){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;
		if (!file_exists($CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$folder_name)) {
			mkdir($CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$folder_name, 0755, true);
			return true;
		}else{
			return false;
		}
	}

	/*==================================================*/
	/*==================================================*/
	/*==================================================*/

	/*==================================================*/
	/*Get folder content*/
	/*==================================================*/
	function getFolderContent($parentPath){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;
		global $ELEMENTS_PER_ROW;

		$loggedUserInfo=getUserInfo();
		$folderPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$parentPath;


		if(!is_dir($folderPath)){
			return "Te requested folder doesn't exist <br/><a href='cloud.php'>Return root</a>";
		}
		$folderContent = scandir($folderPath);


		$html="";

		$checkBoxDefaultStart="<div class='styled-input--diamond'><div class='styled-input-single'>";
        $checkBoxDefaultEnd="</div></div>";
    

		for($i=2;$i<sizeof($folderContent);$i++){

			$file=$folderContent[$i];
			$itemBoxHtml="";



			if(is_dir($folderPath.$file)){
				$image="<img src='images/folder_icon.svg' class='folderIcon' alt='".$folderContent[$i]."'>";

				$itemSelectBox="<input type='checkbox' id='".$parentPath.$folderContent[$i].$FOLDER_SEPARATOR."' class='checkboxItemSelector folderFileItem' name='itemSelector' value='".$parentPath.$folderContent[$i].$FOLDER_SEPARATOR."'>";
				$itemSelectBox=$itemSelectBox."<label for='".$parentPath.$folderContent[$i].$FOLDER_SEPARATOR."'></label>";
				$itemSelectBox=$checkBoxDefaultStart.$itemSelectBox.$checkBoxDefaultEnd;

				$objectHtml="<div for='".$parentPath.$folderContent[$i].$FOLDER_SEPARATOR."' class='subFolderLink'>".$image."<p>".$folderContent[$i]."</p></div>";
				$itemBoxHtml="<div class='folderObjectBox'>".$objectHtml.$itemSelectBox."</div>";
			}else{
				$image="<img src='images/image_file_icon.svg' class='fileIcon' alt='".$folderContent[$i]."'>";

				$itemSelectBox="<input type='checkbox' id='".$parentPath.$folderContent[$i]."' class='checkboxItemSelector objectFileItem' name='itemSelector' value='".$parentPath.$folderContent[$i]."'>";
				$itemSelectBox=$itemSelectBox."<label for='".$parentPath.$folderContent[$i]."'></label>";
				$itemSelectBox=$checkBoxDefaultStart.$itemSelectBox.$checkBoxDefaultEnd;

				$objectHtml="<div data-filename='".$parentPath.$folderContent[$i]."' class='folderItem' data-filepath='".$folderPath.$file."'>".$image."<p>".$folderContent[$i]."</p></div>";
				$itemBoxHtml="<div class='folderObjectBox'>".$objectHtml.$itemSelectBox."</div>";
			}

			$html=$html.$itemBoxHtml;

		}
		
		return $html;
	}
	/*==================================================*/
	/*Expand an user folder*/
	/*==================================================*/
	function expandFolderTree($parentPath){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;

		$loggedUserInfo=getUserInfo();
		$folderPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$parentPath;
		$folderContent = scandir($folderPath);

		$htmlTree="<ul class='folder_tree_ul'>";

		for($i=2;$i<sizeof($folderContent);$i++){

			$file=$folderContent[$i];

			if(is_dir($folderPath.$file)){
				$image="<img src='images/arrow_right.svg' style='width: 12px; height: 12px;'  class='folderExpandIcon'>";
				$start="<li><div>".$image."<a href='#' data-filename='".$parentPath.$folderContent[$i].$FOLDER_SEPARATOR."' class='folderLink collapsed'>";
				$end="</a><div></div></div></li>";
				$htmlTree=$htmlTree.$start.$folderContent[$i].$end;
			}

		}
		return $htmlTree."</ul>";
	}
	/*==================================================*/
	/*Set folder path*/
	/*==================================================*/
	function setFolderPath($folderPath){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;

		$loggedUserInfo=getUserInfo();
		$folderPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$folderPath;

		$pieces = explode($FOLDER_SEPARATOR, $folderPath); 	

		$htmlFolderPath="<a href='#' for=".$FOLDER_SEPARATOR." class='folderPathLink'>Home</a> &gt; ";
		$tmpPath="";

		for($i=3;$i<sizeof($pieces)-1;$i++){
			$tmpPath=$tmpPath.$FOLDER_SEPARATOR.$pieces[$i];
			$htmlFolderPath=$htmlFolderPath."<a href='#' for='".$tmpPath.$FOLDER_SEPARATOR."' class='folderPathLink'>".$pieces[$i]."</a> &gt; ";
		}

		return $htmlFolderPath;
	}
	/*==================================================*/
	/*Auto expand an user folder*/
	/*==================================================*/
	function autoExpandFolderTree($folderStartPath,$folderEndPath){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;

		$loggedUserInfo=getUserInfo();
		$folderStartPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$folderStartPath;
		$folderEndPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$folderEndPath;

		//recursive function to expand the folder tree until the required folder
		return autoExpansion($folderStartPath,$folderEndPath);

	}
	function autoExpansion($folderStartPath,$folderEndPath){
		global $FOLDER_SEPARATOR;

		//get the sub-folders that the recursion have to go through
		$piecesStart = explode($FOLDER_SEPARATOR, $folderStartPath); 	
		$piecesEnd = explode($FOLDER_SEPARATOR, $folderEndPath);
		//generation of the starting filepath point for each recursion (same of the link's data-filename of the current step)
		$filename="";
		for($i=3;$i<sizeof($piecesStart);$i++){
			$filename=$filename.$FOLDER_SEPARATOR.$piecesStart[$i];
		}
		//generation of the comparison path to see which inner folder is the required one to go through
		$comparisonPath="";
		for($i=0;$i<sizeof($piecesStart);$i++){
			if($i==0){
				$comparisonPath=$piecesEnd[$i];
			}else{
				$comparisonPath=$comparisonPath.$FOLDER_SEPARATOR.$piecesEnd[$i];
			}
		}
		if(substr($comparisonPath, -1)!=$FOLDER_SEPARATOR){
			$comparisonPath=$comparisonPath.$FOLDER_SEPARATOR;
		}
		//get the content of the folder to the relative recursion step
		$folderContent = scandir($folderStartPath);

		$htmlTree="<ul class='folder_tree_ul'>";
		//from $i=2 because the first two folders are "../" and "./"
		for($i=2;$i<sizeof($folderContent);$i++){
			//analyse objects inside a folder
			$fileObject=$folderContent[$i];
			//this creates the reached path of the recursion
			$filePath=$folderStartPath.$fileObject;

			if(is_dir($filePath)){
				//if the file inside the folder that it is going to analyse is a directory
				//add last character
				$filePath=$filePath.$FOLDER_SEPARATOR;
				//this creates the required text-form for the html tag "data-filename" --> it is needed to avoid the starting folders
				$dataFilename=$filename.$fileObject.$FOLDER_SEPARATOR;
				
				if($filePath==$comparisonPath){
					//if it is going to analyze the needed sub-folder to go through to reach the end/required folder
					if($filePath==$folderEndPath){
						//if the end/required folder is reached
						$image="<img src='images/arrow_right.svg' style='width: 12px; height: 12px;'  class='folderExpandIcon'>";
						$start="<li><div>".$image."<a href='#' data-filename='".$dataFilename."' class='folderLink collapsed'>";
						$end="</a><div>".expandFolderTree($dataFilename)."</div></div></li>";
						$htmlTree=$htmlTree.$start.$fileObject.$end;
					}else{
						//if the end/required folder is not reached yet
						$image="<img src='images/arrow_down.svg' style='width: 12px; height: 12px;'  class='folderExpandIcon'>";
						$start="<li><div>".$image."<a href='#' data-filename='".$dataFilename."' class='folderLink expanded'>";
						//this creates a recursion
						$end="</a><div>".autoExpansion($filePath,$folderEndPath)."</div></div></li>";
						$htmlTree=$htmlTree.$start.$fileObject.$end;
					}
				}else{
					//if this is another folder NOT needed to go through to reach the end/required folder
					$image="<img src='images/arrow_right.svg' style='width: 12px; height: 12px;'  class='folderExpandIcon'>";
					$start="<li><div>".$image."<a href='#' data-filename='".$dataFilename."' class='folderLink collapsed'>";
					$end="</a><div></div></div></li>";
					$htmlTree=$htmlTree.$start.$fileObject.$end;
				}
			}
		}
		return $htmlTree."</ul>";
	}
	// removing a file (or directory)
	function deleteItems($itemsPaths){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;

		$loggedUserInfo=getUserInfo();
		
		for($i=0;$i<sizeof($itemsPaths);$i++){
			$filePath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$itemsPaths[$i];
			if(is_dir($filePath)){
				rrmdir($filePath);
			}else{
				unlink($filePath);
			}
		}
		updateDbUsedSpace();
		return "Deleted";
	}

	function rrmdir($src) {
	    $dir = opendir($src);
	    while(false !== ( $file = readdir($dir)) ) {
	        if (( $file != '.' ) && ( $file != '..' )) {
	            $full = $src.'/'.$file;
	            if ( is_dir($full) ) {
	                rrmdir($full);
	            }
	            else {
	                unlink($full);
	            }
	        }
	    }
	    closedir($dir);
	    rmdir($src);
	}

	//create new folder
	function addFolder($currentPath,$folderName){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;
		$loggedUserInfo=getUserInfo();
		$folderPath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$currentPath.$folderName;

		if (!file_exists($folderPath)) {
			mkdir($folderPath, 0755, true);
			return true;
		}else{
			return false;
		}
	}

	//rename file
	function renameFile($fileNamePath,$newFileName){

		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;
		$loggedUserInfo=getUserInfo();
		$fileNamePath="..".$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"].$fileNamePath;
		$oldFileNamePath=$fileNamePath;

		if (is_dir($fileNamePath)) {
			$fileNamePath = substr($fileNamePath, 0, -1); 
			$fileNamePath = substr($fileNamePath, 0, strrpos( $fileNamePath, '/'));
			$newFileNamePath = $fileNamePath.$FOLDER_SEPARATOR.$newFileName.$FOLDER_SEPARATOR;
			rename($oldFileNamePath, $newFileNamePath);
	    }
		else {
			$fileExtension = substr($fileNamePath, strrpos($fileNamePath, '.') + 1);
			$fileNamePath = substr($fileNamePath, 0, strrpos( $fileNamePath, '/'));
			$newFileNamePath = $fileNamePath.$FOLDER_SEPARATOR.$newFileName.'.'.$fileExtension;
			rename($oldFileNamePath, $newFileNamePath);
		}
		
		return true;
	}

	// change account info
	function changeInfo($toChange,$newValue){
		if (session_status() == PHP_SESSION_NONE) {
    		session_start();
		}

		global $SESSION_KEY_COOKIE_NAME;
		global $LOGGED_EMAIL_COOKIE_NAME;
		if(checkLogin()){
			$loggedUserInfo=getUserInfo();
			$db = getDB();
			
			$statement=NULL;
			if($toChange=="name"){
				$statement = $db->update("users",
						["name" => $newValue],
						["id"=>$loggedUserInfo["ID"]]);
			}else if($toChange=="surname"){
				$statement = $db->update("users",
						["surname" => $newValue],
						["id"=>$loggedUserInfo["ID"]]);
			}else if($toChange=="email"){


				$alreadyExist = $db->select('users', array('ID'), ["email" => $newValue]);
				if(count($alreadyExist)==1){
					return false;
				}else{
					$statement = $db->update("users",
					["email" => $newValue],
					["id"=>$loggedUserInfo["ID"]]);
					if($statement->rowCount()==1){
				 		$_SESSION[$LOGGED_EMAIL_COOKIE_NAME] = $newValue;
					}
				}
			
			}else if($toChange=="password"){
				$samePassword = $db->select('users', array('ID'), ["AND" =>["password" =>  md5($newValue), "id"=>$loggedUserInfo["ID"]]]);

				if(count($samePassword)==1){
					return -1;
				}else{
					$statement = $db->update("users",
							["password" => md5($newValue)],
							["id"=>$loggedUserInfo["ID"]]);
				}
			}
			if(is_null($statement)){
				return false;
			}

			if($statement->rowCount()==1 && $toChange!="password"){
				return $newValue;
			}else if($statement->rowCount()==1 && $toChange=="password"){
				return true;
			}
			return false;
		}
		return true;
	}

	// Storage space management and file sizes
	function getStorageStatus($beginningPath=".."){
		updateDbUsedSpace($beginningPath);
		$loggedUserInfo=getUserInfo();
		$db = getDB();
		$planDetails = $db->select('users', array('STORAGE_LIMIT','CURRENT_USED_SPACE'), ["id"=>$loggedUserInfo["ID"]]);
		if(count($planDetails)==1){
			return $planDetails[0];
		}else{
			return false;
		}
	}

	function updateDbUsedSpace($beginningPath=".."){
		$loggedUserInfo=getUserInfo();
		$db = getDB();
		$usedSpaceSize=getUserUsedSpace($beginningPath);
		$statement = $db->update("users",
						["CURRENT_USED_SPACE" => $usedSpaceSize],
						["id"=>$loggedUserInfo["ID"]]);

		if($statement->rowCount()==1){
			return true;
		}else{
			return false;
		}
	}

	function checkIfFileSizeFits($newFileSize,$beginningPath=".."){
		$loggedUserInfo=getUserInfo();
		$db = getDB();
		$planDetails = $db->select('users', array('STORAGE_LIMIT'), ["id"=>$loggedUserInfo["ID"]]);
		if(count($planDetails)==1){
			$usedSpaceSize=getUserUsedSpace($beginningPath);
			$storageLimit=$planDetails[0]["STORAGE_LIMIT"];

			if(($usedSpaceSize+$newFileSize)<=$storageLimit){
				return true;
			}else{
				return false;
			}
		}
		return -1;
	}

	function getUserUsedSpace($beginningPath=".."){
		global $CLOUD_FOLDER_NAME;
		global $FOLDER_SEPARATOR;
		$loggedUserInfo=getUserInfo();
		$userFolderPath=$beginningPath.$FOLDER_SEPARATOR.$CLOUD_FOLDER_NAME.$FOLDER_SEPARATOR.$loggedUserInfo["FOLDER"];
		return folderSize($userFolderPath);
	}

	function folderSize($dir){
    	$size = 0;
    	foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
        	$size += is_file($each) ? filesize($each) : folderSize($each);
    	}
    	return $size;
	}


?>