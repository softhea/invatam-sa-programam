<?php

require 'includes/common.php';

redirectIfNotLogged();

$username = '';
$roleId = 0;
$email = '';
$error = '';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$user = findUser($userId);
if ($user === null) {
	$error = 'User not found!';
} else {
	$username = $user['username'];
	$email = $user['email'];
	$roleId = (int)$user['role_id'];
	
	if (isset($_POST['save'])) {
		$newUsername = trim($_POST['username']);
		if ($newUsername === '') {
			$error = 'Invalid username!';
		} else {
			$newEmail = trim($_POST['email']);
			if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
				$error = 'Invalid email!';
			} else {
				$newPassword = trim($_POST['password']);
				$updatePassword = '';
				if ($newPassword !== '') {
					$newPassword = md5($newPassword);
					$updatePassword = ", password = '".$newPassword."'";
				}
				
				$newRoleId = (int)($_POST['role_id']);
				if ($roleId === 0 || !array_key_exists($roleId, $roles)) {
					$error = 'Invalid role!';
				} else {
					if (
						$username === $newUsername &&
						$email === $newEmail &&
						$roleId === $newRoleId &&
						$newPassword === ''
					) {
						$error = 'No update!';
					} else {
						$otherUser = findOtherUserByUsernameOrEmail((int)$user['id'], $newUsername, $newEmail);
						if ($otherUser !== null) {
							$error = 'User Already Exists!';
						} else {							
							updateUser((int)$user['id'], $newUsername, $newEmail, $newRoleId, $updatePassword);
					
							redirect('users.php?message=User '.$newUsername.' has been updated!');
						}		
					}	
				}
			}
		}
	}
}

include 'views/menu.html.php';
include 'views/edit-user.html.php';