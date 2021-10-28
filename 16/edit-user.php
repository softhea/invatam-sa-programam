<?php

require 'includes/common.php';

redirectIfNotLogged();

$username = '';
$roleId = 0;
$email = '';
$error = '';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$query = "SELECT * FROM users WHERE id = ".$userId;
$result = mysqli_query($databaseConnection, $query);
$user = mysqli_fetch_assoc($result);
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
						$query = 
							"SELECT id FROM users 
							WHERE 
							(username = '".$newUsername."' OR email = '".$newEmail."')
							AND id != ".(int)$user['id'];

						$result = mysqli_query($databaseConnection, $query);
						$otherUser = mysqli_fetch_assoc($result);
						if ($$otherUser !== null) {
							$error = 'User Already Exists!';
						} else {
							$query = 
								"UPDATE users SET 
								username = '".$newUsername."'
								, email = '".$newEmail."'
								, role_id = '".$newRoleId."'
								".$updatePassword."
								WHERE id = ".(int)$user['id'];
								//die($query);
							mysqli_query($databaseConnection, $query);
					
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