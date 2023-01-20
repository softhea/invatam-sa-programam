<?php

require 'includes/common.php';

redirectIfNotLogged();

$user = null;
//$message = isset($_GET['message']) ? $_GET['message'] : '';
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if (0 !== $userId) {
	$userRepository = new UserRepository();
	$user = $userRepository->find($userId);
}
$username = '';
if (null !== $user->id) {
	$username = $user->username;
}

if (isset($_POST['send'])) {
	$message = new Message();
	$message->senderId = $loggedUserId;
	$message->receiverId = $userId;
	$message->message = $_POST['message'];
	$message->save();

	redirect('users.php?message=Message sent.');
}

include 'views/send-message.html.php';
