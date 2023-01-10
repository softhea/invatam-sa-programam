<?php

require 'includes/common.php';

redirectIfNotLogged();

$error = '';
$username = '';
$email = '';
$roleId = 0;
if (isset($_POST['save'])) {
	$user = new User($_POST);
	$error = $user->create();
	
	if ('' === $error) {
		redirect('users.php?message=User created successfuly');	
	}
	
	$username = $user->username;
	$email = $user->email;
	$roleId = $user->roleId;
}

include 'views/menu.html.php';
include 'views/add-user.html.php';
