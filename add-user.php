<?php

use App\Models\User;
use App\Validators\UserValidator;

require 'includes/common.php';

redirectIfNotLogged();

$error = '';
$username = '';
$email = '';
$roleId = 0;

if (isset($_POST['save'])) {
	$user = new User($_POST);
	$userValidator = new UserValidator($user);
	$error = $userValidator->validateCreate();
	if ('' === $error) {
		$user->save();
		redirect('users.php?message=User created successfuly');	
	}
	
	$username = $user->username;
	$email = $user->email;
	$roleId = $user->roleId;
}

include 'views/add-user.html.php';
