<?php 

require 'includes/common.php';

redirectIfNotLogged();

$message = isset($_GET['message']) ? $_GET['message'] : '';

$where = "";
if ($_SESSION['role_id'] === 3) {
	$where = " WHERE role_id = 3";	
} elseif ($_SESSION['role_id'] === 2) {
	$where = " WHERE role_id >= 2";	
}

$query = "SELECT id, username, email, register_code, role_id FROM users ".$where;

$result = mysqli_query($databaseConnection, $query);

$users = [];
while ($user = mysqli_fetch_assoc($result)) {
	$users[] = $user;
}

include 'views/menu.html.php';
include 'views/users.html.php';
