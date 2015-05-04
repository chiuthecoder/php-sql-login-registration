<?php
require('connection.php');
session_start();

if(isset($_POST['action']) && $_POST['action'] == "login")
{

  $query = "SELECT id, email, password FROM users WHERE email = '{$_POST['email']}' AND password = '{$_POST['password']}'";
    	// echo $query;
    	// die();
  $result = fetch_record($query);
  // var_dump($result);
  if($result)
  {
  	$_SESSION['user'] = $result;

  	header('Location: success.php');
  	exit();
  }
  else
  {
  	header('Location: index.php');
  	exit();
  }
}

elseif(isset($_POST['action']) && $_POST['action'] == "register")
{

	$errors = array();

	if(empty($_POST['first_name'])){
		$errors[] = "first name can't be blank.";
	}
	if(empty($_POST['last_name'])){
		$errors[] = "last name can't be blank.";
	}
	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = "your email is blank or is invalid.";
	}
	if(empty($_POST['password'])){
		$errors[] = "password can't be blank.";
	}
	if(count($errors) > 0)
	{
		//if there are errors, assign the session variable
		$_SESSION['errors'] = $errors;
		header('Location: index.php');
	}
	else{
		$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) 
		VALUES ('{$_POST['first_name']}','{$_POST['last_name']}','{$_POST['email']}','{$_POST['password']}',NOW(),NOW() )";
		// var_dump($query);
		// die();
		run_mysql_query($query);
		$_SESSION['success'] = "Your information was valid!";

	    header('Location: success.php');
	}
}




?>