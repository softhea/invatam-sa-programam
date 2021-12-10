<?php 

require 'includes/common.php';

redirectIfNotLogged();

$message = isset($_GET['message']) ? $_GET['message'] : '';

$users = getUsers();

include 'views/users.html.php';
