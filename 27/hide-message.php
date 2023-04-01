<?php

use App\Repositories\MessageRepository;

require 'includes/common.php';

redirectIfNotLogged();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (0 === $id) {
	redirect('messages.php?error=Invalid Message ID!');
}

$messageRepository = new MessageRepository();
$message = $messageRepository->find($id);
if (!$message->exists()) {
	redirect('messages.php?error=Message not found!');
}

$message->hide();	

redirect('messages.php?message=Message has been hidden.');
