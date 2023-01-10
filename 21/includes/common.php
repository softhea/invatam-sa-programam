<?php

session_start();

require 'config.php';
require __DIR__.'/../models/user.php';
require __DIR__.'/../models/message.php';

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

$databaseConnection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$logged = false;	
$userName = '';
$loggedUserId = 0;
if (isset($_SESSION['logged'])) {
	$logged = true;	
	$userName = $_SESSION['username'];
	$loggedUserId = $_SESSION['user_id'];
}
