<?php

$message = '';
$error = '';
$code = $_GET['register_code'];

$query = "SELECT id FROM users WHERE register_code = '".$code."'";

$databaseConnection = mysqli_connect('localhost', 'root', '', 'invatam_sa_programam');
$result = mysqli_query($databaseConnection, $query);
$user = mysqli_fetch_assoc($result);
if ($user !== null) {
	$query = "UPDATE users SET register_code = NULL WHERE id = ".(int)$user['id'];
	mysqli_query($databaseConnection, $query);
	$message = 'Success!';
} else {
	$error = 'Invalid register code!';
}

echo $message.'<br>'.$error;
