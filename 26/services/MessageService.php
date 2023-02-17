<?php

class MessageService
{
    public function markAsRead(array $messageIds): void
	{
		$messageRepository = new MessageRepository();
		$messages = $messageRepository->findByIds($messageIds);
		foreach ($messages as $message) {
			$message->markAsRead();
		}
	}
}
