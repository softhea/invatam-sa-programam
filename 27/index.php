<?php

require 'includes/common.php';

redirectIfNotLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$message = isset($_GET['message']) ? $_GET['message'] : '';

include 'views/home.html.php';
