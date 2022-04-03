<?php

require 'includes/common.php';

redirectIfNotLogged();

$user = null;
//$message = isset($_GET['message']) ? $_GET['message'] : '';
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if (0 !== $userId) {
	$user = findUser($userId);
}
$username = '';
if (isset($user['username'])) {
	$username = $user['username'];
}

if (isset($_POST['send'])) {
	sendMessage($userId, $_POST['message']);
	redirect('users.php?message=Message sent.');
}

include 'views/send-message.html.php';
