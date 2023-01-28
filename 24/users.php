<?php 

require 'includes/common.php';

redirectIfNotLogged();

$message = isset($_GET['message']) ? $_GET['message'] : '';

$userRepository = new UserRepository();
$users = $userRepository->findAll();

include 'views/users.html.php';
