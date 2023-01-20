<?php

class MessageRepository
{
	public function findAll(): array
	{
		global $databaseConnection, $loggedUserId;

		$query =
			"SELECT m.*, s.username AS sender, r.username AS receiver 
			FROM messages m
			JOIN users s ON m.sender_id = s.id
			JOIN users r ON m.receiver_id = r.id		
			WHERE m.sender_id = " . $loggedUserId . " 
			OR (m.receiver_id = " . $loggedUserId . " AND m.is_hidden = 0)";

		$result = mysqli_query($databaseConnection, $query);

		$messages = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$messages[] = new Message($row);
		}

		return $messages;
	}

	public function find(int $id): Message
	{
		global $databaseConnection;

		$query =
			"SELECT m.*, s.username AS sender, r.username AS receiver 
			FROM messages m
			JOIN users s ON m.sender_id = s.id
			JOIN users r ON m.receiver_id = r.id		
			WHERE m.id = " . $id . " LIMIT 1";

		$result = mysqli_query($databaseConnection, $query);

		return new Message(mysqli_fetch_assoc($result));	
	}
}
