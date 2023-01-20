<?php

session_start();

require 'config.php';
require __DIR__.'/../models/User.php';
require __DIR__.'/../models/Message.php';
require __DIR__.'/../repositories/UserRepository.php';
require __DIR__.'/../repositories/MessageRepository.php';
require __DIR__.'/../services/MessageService.php';
require __DIR__.'/../validators/UserValidator.php';

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
