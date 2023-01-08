<?php

require 'UserModel.php';

const ROLE_ID_SUPER_ADMIN = 1;
const ROLE_ID_ADMIN = 2;
const ROLE_ID_USER = 3;

$roles = [
	ROLE_ID_SUPER_ADMIN => 'Super Admin',
	ROLE_ID_ADMIN => 'Admin',
	ROLE_ID_USER => 'User',
];

function getUsers(): array
{
	global $databaseConnection;
	
	$where = "";
	if ($_SESSION['role_id'] === ROLE_ID_USER) {
		$where = " WHERE role_id = ".ROLE_ID_USER;	
	} elseif ($_SESSION['role_id'] === ROLE_ID_ADMIN) {
		$where = " WHERE role_id >= ".ROLE_ID_ADMIN;	
	}

	$query = "SELECT id, username, email, register_code, role_id FROM users ".$where;

	$result = mysqli_query($databaseConnection, $query);

	$users = [];
	while ($user = mysqli_fetch_assoc($result)) {
		$users[] = new User($user);
	}
	
	return $users;
}

function findUserByUsernameOrEmail(string $username, string $email): ?array
{
	global $databaseConnection;
	
	$query = "SELECT id FROM users WHERE username = '".$username."' OR email = '".$email."'";

	$result = mysqli_query($databaseConnection, $query);
	
	return mysqli_fetch_assoc($result);
}

function findOtherUserByUsernameOrEmail(int $id, string $username, string $email): ?array
{
	global $databaseConnection;
	
	$query = 
		"SELECT id FROM users 
		WHERE 
			(username = '".$username."' OR email = '".$email."') AND 
			id != ".$id;

	$result = mysqli_query($databaseConnection, $query);
	
	return mysqli_fetch_assoc($result);
}

function findUser(int $id): ?array
{
	global $databaseConnection;
	
	$query = "SELECT * FROM users WHERE id = ".$id;
	$result = mysqli_query($databaseConnection, $query);
	
	return mysqli_fetch_assoc($result);
}
							
function updateUser(int $id, string $newUsername, string $newEmail, int $newRoleId, string $updatePassword): void
{
	global $databaseConnection;
	
	$query = 
		"UPDATE users SET 
		username = '".$newUsername."'
		, email = '".$newEmail."'
		, role_id = '".$newRoleId."'
		".$updatePassword."
		WHERE id = ".$id;
		
	mysqli_query($databaseConnection, $query);	
}

function deleteUser(int $id): void
{
	global $databaseConnection;
	
	$query = "DELETE FROM users WHERE id = ".$id;

	mysqli_query($databaseConnection, $query);
}
