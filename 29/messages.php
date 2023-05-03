<?php

use App\Repositories\MessageRepository;
use App\Services\MessageService;
use Core\Auth;

require 'includes/common.php';

redirectIfNotLogged();

$error = isset($_GET['error']) ? $_GET['error'] : '';
$response = isset($_GET['message']) ? $_GET['message'] : '';

$messageRepository = new MessageRepository();
$messages = $messageRepository->findBySenderOrNotHiddenByReceiver(Auth::id());

$messageIds = [];
foreach ($messages as $message) {
	if (!$message->isRead) {
		$messageIds[] = $message->id;
	}
}

$messageService = new MessageService();
$messageService->markAsRead($messageIds);

include 'views/messages.html.php';
