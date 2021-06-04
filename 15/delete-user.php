<?php

require 'includes/common.php';

redirectIfNotLogged();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$query = "DELETE FROM users WHERE id = ".$userId;

mysqli_query($databaseConnection, $query);

redirect('users.php');