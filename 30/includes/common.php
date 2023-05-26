<?php

use Core\Auth;

require __DIR__.'/../vendor/autoload.php';

require 'config.php';

function redirect($uri)
{
	header('location: '.$uri);
	exit;
}

function redirectIfNotLogged()
{
	if (!Auth::isLogged()) {
		redirect('login');
	}
}

function redirectIfLogged()
{
	if (Auth::isLogged()) {
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
