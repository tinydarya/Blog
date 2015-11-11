<?php 
require_once 'dbCon.php';
if($_POST) {

	$email = mysqli_real_escape_string($con, strip_tags(trim($_POST['email'])));

	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
 		$val_email = $email;
  	} else {
		$errmsg_email = "<div class='errormsg'>Please enter valid email";
  	}
	
	if (isset($_POST['password']) && !empty($_POST['password'])) {
		$val_password = sha1(mysqli_real_escape_string($con, strip_tags(trim($_POST['password']))));
	} else{
		$errmsg_password = "<div class='errormsg'>Please enter valid password </div>";
	}
 
	if (isset($val_email) && isset($val_password) && (strlen($val_email) > 0) && (strlen($val_password) > 0) ) {
		$sql = mysqli_query($con, "SELECT * FROM user where email='$val_email' and password='$val_password'");
		
		if (mysqli_num_rows($sql)==0) {
			$noUser = "<div class='errormsg'>Invalid Login</div>";
		} else {
			while ($row = mysqli_fetch_array($sql)){
          		$name = $row['name'];
          		$user_id = $row['id'];
        	}
			session_start();
			$_SESSION['username']=$name;
			$_SESSION['user_id']=$user_id;
			header("Location: index.php");
		}
    }
}
?>