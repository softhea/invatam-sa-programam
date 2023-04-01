<?php

session_start();

require __DIR__.'/../vendor/autoload.php';

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

function dump($text)
{
	echo "<pre>";
	var_dump($text);
	echo "</pre>";
}

function dd($text)
{
	dump($text);
	die;
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
