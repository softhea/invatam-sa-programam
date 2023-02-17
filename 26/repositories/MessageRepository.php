<?php

class MessageRepository
{
	public function findBySenderOrNotHiddenByReceiver(int $userId): array
	{
		$query =
			"SELECT m.*, s.username AS sender, r.username AS receiver 
			FROM messages m
			JOIN users s ON m.sender_id = s.id
			JOIN users r ON m.receiver_id = r.id		
			WHERE m.sender_id = " . $userId . " 
			OR (m.receiver_id = " . $userId . " AND m.is_hidden = 0)";

		return DB::readAll($query, Message::class);	
	}

	public function findByIds(array $messageIds): array 
	{
		if ([] === $messageIds) {
			return [];
		}

		$messageIds = implode(',', $messageIds);

		$query =
			"SELECT m.*, s.username AS sender, r.username AS receiver 
			FROM messages m
			JOIN users s ON m.sender_id = s.id
			JOIN users r ON m.receiver_id = r.id		
			WHERE m.id IN (".$messageIds.")";

		return DB::readAll($query, Message::class);	
	}

	public function find(int $id): Message
	{
		$query =
			"SELECT m.*, s.username AS sender, r.username AS receiver 
			FROM messages m
			JOIN users s ON m.sender_id = s.id
			JOIN users r ON m.receiver_id = r.id		
			WHERE m.id = " . $id . " LIMIT 1";

		return DB::readOne($query, Message::class);	
	}
}
