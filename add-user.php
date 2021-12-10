<?php

require 'includes/common.php';

redirectIfNotLogged();

$username = '';
$email = '';
$roleId = 0;
$error = '';

if (isset($_POST['save'])) {
	$username = trim($_POST['username']);
	if ($username === '') {
		$error = 'Invalid username!';
	} else {
		$email = trim($_POST['email']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error = 'Invalid email!';
		} else {
			$password = trim($_POST['password']);
			if ($password === '') {
				$error = 'Invalid password!';
			} else {
				$password = md5($password);
				
				$user = findUserByUsernameOrEmail($username, $email);
				
				if ($user !== null) {
					$error = 'User Already Exists!';
				} else {
					$roleId = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
					if ($roleId === 0) {
						$error = 'Invalid role!';
					} else {
						createUser($username, $email, $password, $roleId);
				
						redirect('users.php');	
					}
				}			
			}
		}
	}
}

include 'views/menu.html.php';
include 'views/add-user.html.php';
