<?php

class MessageService
{
    public function markAsRead(array $messageIds): void
	{
		global $databaseConnection, $loggedUserId;

		$messageIds = implode(',', $messageIds);
		$query =
			"UPDATE messages 
			SET is_read = 1 
			WHERE receiver_id = " . $loggedUserId . " 
			AND id IN (" . $messageIds . ")";

		mysqli_query($databaseConnection, $query);
	}
}
