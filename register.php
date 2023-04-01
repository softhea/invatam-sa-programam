<?php

use App\Models\User;
use App\Validators\UserValidator;

require 'includes/common.php';

redirectIfLogged();

$username = '';
$email = '';
$error = '';

if (isset($_POST['register'])) {
	$user = new User($_POST);
	$user->roleId = User::ROLE_ID_USER;
	
	$userValidator = new UserValidator($user);
	$error = $userValidator->validateCreate();
	if ('' === $error) {
		$registerCode = md5(time().rand(100000, 999999));

		$user->registerCode = $registerCode;
		$user->save();

		$link = SITE_URL.'/confirm.php?register_code='.$registerCode;

		mail(
			$email, 
			'Invatam Sa Programam Registration Confirmation', 
			'Click on: '.$link.' to finalize registration!'
		);
			
		redirect('login.php?message=Please check email and click on received link to confirm registration!');
	}

	$username = $user->username;
	$email = $user->email;
}

include 'views/register.html.php';
