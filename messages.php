<?php 

require 'includes/common.php';

redirectIfNotLogged();

$messages = getMessages();
$messageIds = [];
foreach ($messages as $message) {
	$messageIds[] = $message['id'];
}
markMessagesAsRead($messageIds);

include 'views/messages.html.php';
