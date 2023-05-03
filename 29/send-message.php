<?php

use App\Models\Message;
use App\Repositories\UserRepository;
use Core\Auth;

require 'includes/common.php';

redirectIfNotLogged();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if (0 === $userId) {
	redirect('users.php?error=Invalid User ID!');
}

$userRepository = new UserRepository();
$user = $userRepository->find($userId);
if (!$user->exists()) {
	redirect('users.php?error=User Not Found!');
}

if (isset($_POST['send'])) {
	$message = new Message();
	$message->senderId = Auth::id();
	$message->receiverId = $userId;
	$message->message = $_POST['message'];
	$message->save();

	redirect('users.php?message=Message sent.');
}

include 'views/send-message.html.php';
