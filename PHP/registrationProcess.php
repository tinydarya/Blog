<?php

require_once 'dbCon.php';
if($_POST) 
{
	$fname = mysql_real_escape_string(strip_tags(trim($_POST['firstName']))); 
	$lname = mysql_real_escape_string(strip_tags(trim($_POST['lastName'])));
	$password = mysql_real_escape_string(strip_tags(trim($_POST['password'])));
	$email = mysql_real_escape_string(strip_tags(trim($_POST['email']))); 
	
	if (preg_match('/^[a-z\d_]{3,20}$/i',$fname)){
		$val_firstname = $fname;
	}else{ 
		$errmsg_firstname='<p class="errormsg">Please enter valid Name. Min 3 to max 20 characters long!</p>'; 
	}

 if (preg_match('/^[a-z\d_]{3,20}$/i',$lname)){
		$val_lastname = $lname;
	}else{ 
		$errmsg_lastname='<p class="errormsg">Please enter valid Name. Min 3 to max 20 characters long!</p>'; 
	}
	
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
  {
 	$val_email = $email;
  }
else
  {
$errmsg_email = '<p class="errormsg">Please enter valid Email!</p>'; 
  } 
	
	
	if (preg_match("/^(?=.*\d)(?=.*[a-zA-Z]).{6,8}/", $password)){
		$val_password = $password;
	}else{ 
		$errmsg_password = '<p class="errormsg">Please enter valid Password (Min 6 to max 8 characters, combination of alphanumeric!)</p>'; 
	}
 
	if((strlen($val_firstname)>0)&&(strlen($val_email)>0)
			&&(strlen($val_lastname)>0)&&(strlen($val_password)>0) ){
		
		//----------------- to check if the user already exists-----------------
		$sql=  mysql_query("SELECT * FROM users where email='$email'");
		
		if(mysql_num_rows($sql)>0){
			echo "<div class='errormsg'>Sorry This email already exists</div>";
			}
		
		//--------------------------End of user check ----------------------
		else{
		//----------------------------Else Register New User----------------
		$sql=  mysql_query("INSERT INTO users (firstname, lastname, password,email) 
		values ('$fname','$lname',sha1('$password'), '$email')");
		
		session_start();
	
		$_SESSION['username']=$fname." ".$lname;
		header("Location: memberArea.php");
		}
		//---------------------------End of New User Registration
		
	}
	
}
?>