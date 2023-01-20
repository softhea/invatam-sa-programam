<?php

require 'includes/common.php';

redirectIfNotLogged();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (0 !== $id) {
	$messageRepository = new MessageRepository();
	$message = $messageRepository->find($id);
	if (null !== $message->id) {
		$message->hide();	
	}
}

redirect('messages.php');
