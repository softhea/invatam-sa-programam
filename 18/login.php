<?php

require 'includes/common.php';

redirectIfLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';

if (isset($_POST['login'])) {
	$query = "SELECT id, register_code, role_id FROM users WHERE username = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";

	$result = mysqli_query($databaseConnection, $query);
	$user = mysqli_fetch_assoc($result);
	if ($user !== null) {
		if ($user['register_code'] === null) {
			$_SESSION['logged'] = true;	
			$_SESSION['username'] = $_POST['username'];		
			$_SESSION['role_id'] = (int)$user['role_id'];
			$_SESSION['user_id'] = (int)$user['id'];
			
			redirect('index.php');
		} else {
			$error = 'Please confirm registration by clicking on the link you received at your email address!';	
		}
	} else {
		$error = 'Invalid credentials!';
	}
}

include 'views/login.html.php';
