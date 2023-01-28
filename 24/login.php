<?php

require 'includes/common.php';

redirectIfLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';

if (isset($_POST['login'])) {
	$userRepository = new UserRepository();
	$user = $userRepository->findOneByUsernameAndPassword(
		$_POST['username'], 
		$_POST['password']
	);
	if ($user->id !== null) {
		if ($user->registerCode === null) {
			$_SESSION['logged'] = true;	
			$_SESSION['username'] = $_POST['username'];		
			$_SESSION['role_id'] = $user->roleId;
			$_SESSION['user_id'] = $user->id;
			
			redirect('index.php');
		} else {
			$error = 'Please confirm registration by clicking on the link you received at your email address!';	
		}
	} else {
		$error = 'Invalid credentials!';
	}
}

include 'views/login.html.php';
