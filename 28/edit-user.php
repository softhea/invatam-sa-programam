<?php

use App\Models\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

require 'includes/common.php';

redirectIfNotLogged();

$error = '';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$userRepository = new UserRepository();
$user = $userRepository->find($userId);
if (!$user->exists()) {
	redirect('users.php?error=User not found!');
}

if (isset($_POST['save'])) {
	$newUser = new User($_POST);
	$userValidator = new UserValidator($newUser);
	$error = $userValidator->validateUpdate($user);
	if ('' === $error) {
		$user->username = $newUser->username;
		$user->email = $newUser->email;
		$user->roleId = $newUser->roleId;
		if (null !== $userValidator->password) {
			$user->password = $userValidator->password;
		}
		$user->save();

		redirect('users.php?message=User '.$user->username.' has been updated!');
	}
}

include 'views/edit-user.html.php';