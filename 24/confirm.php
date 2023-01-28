<?php

require 'includes/common.php';

redirectIfLogged();

$message = '';
$error = '';
$registerCode = $_GET['register_code'];

$userRepository = new UserRepository();
$user = $userRepository->findOneByRegisterCode($registerCode);
if ($user->id !== null) {
	$user->registerCode = null;
	$user->save();
	
	$message = 'Success!';
} else {
	$error = 'Invalid register code!';
}

redirect('login.php?message='.$message.'&error='.$error);
