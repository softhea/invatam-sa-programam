<?php

require 'includes/common.php';

redirectIfNotLogged();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

deleteUser($userId);

redirect('users.php');