<?php

use Core\Auth;

function redirect(string $uri): void
{
	header('location: '.$uri);
	exit;
}

function redirectIfNotLogged(): void
{
	if (!Auth::isLogged()) {
		redirect('login');
	}
}

function redirectIfLogged(): void
{
	if (Auth::isLogged()) {
		redirect(HOME_URL);
	}
}

function dump($text): void
{
	echo "<pre>";
	var_dump($text);
	echo "</pre>";
}

function dd($text): void
{
	dump($text);
	die;
}
