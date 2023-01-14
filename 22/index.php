<?php

require 'includes/common.php';

redirectIfNotLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';

include 'views/menu.html.php';
include 'views/home.html.php';
