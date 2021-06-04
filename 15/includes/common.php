<?php

session_start();

require 'config.php';

function redirect($uri)
{
	header('location: '.$uri);
	exit;
}

function redirectIfNotLogged()
{
	global $logged;
	
	if (!$logged) {
		redirect('login.php');
	}
}

function redirectIfLogged()
{
	global $logged;
	if ($logged) {
		redirect('index.php');
	}
}

$roles = [
	1 => 'Super Admin',
	2 => 'Admin',
	3 => 'User',
];

$databaseConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$logged = false;	
$userName = '';
if (isset($_SESSION['logged'])) {
	$logged = true;	
	$userName = $_SESSION['username'];
}
