<?php

use App\Repositories\UserRepository;
use Core\Auth;

require 'includes/common.php';

redirectIfLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

if (isset($_POST['login'])) {
	$userRepository = new UserRepository();
	$user = $userRepository->findOneByUsernameAndPassword(
		$_POST['username'], 
		$_POST['password']
	);
	if ($user->exists()) {
		if ($user->isActive()) {

			Auth::login($user);
			
			redirect('index.php');
		}
		
		$error = 
			'Please confirm registration by clicking on the link'.
			' you received at your email address!';	
	} else {
		$error = 'Invalid credentials!';
	}
}

include 'views/login.html.php';
