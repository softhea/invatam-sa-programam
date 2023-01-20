<?php 

require 'includes/common.php';

redirectIfNotLogged();

$messageRepository = new MessageRepository();
$messages = $messageRepository->findAll();

$messageIds = [];
foreach ($messages as $message) {
	$messageIds[] = $message->id;
}

$messageService = new MessageService();
$messageService->markAsRead($messageIds);

include 'views/messages.html.php';
