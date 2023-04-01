<?php

namespace App\Models;

use App\Database\DB;

class Message
{
	public ?int $id = null;
	public ?int $senderId = null;
	public ?int $receiverId = null;
	public ?string $sender = null;
	public ?string $receiver = null;
	public ?string $message = null;
	public bool $isRead = false;
	public bool $isHidden = false;
	public ?string $dateAndTime = null;
	
	public function __construct(?array $user = [])
	{
		if (isset($user['id'])) {
			$this->id = (int)$user['id'];	
		}
		if (isset($user['sender_id'])) {
			$this->senderId = (int)$user['sender_id'];
		}
		if (isset($user['receiver_id'])) {
			$this->receiverId = (int)$user['receiver_id'];
		}
		if (isset($user['sender'])) {
			$this->sender = trim($user['sender']);
		}
		if (isset($user['receiver'])) {
			$this->receiver = trim($user['receiver']);
		}
		if (isset($user['message'])) {
			$this->message = trim($user['message']);
		}
		if (isset($user['is_read'])) {
			$this->isRead = (bool)$user['is_read'];
		}
		if (isset($user['is_hidden'])) {
			$this->isHidden = (bool)$user['is_hidden'];
		}
		if (isset($user['date_and_time'])) {
			$this->dateAndTime = trim($user['date_and_time']);
		}
	}

	public function save(): void
	{
		$query =
			"INSERT INTO messages (
				sender_id, receiver_id, message, is_read, date_and_time
			) VALUES (
				" . $this->senderId . ", 
				" . $this->receiverId . ", 
				'" . $this->message . "', 
				0, 
				'" . date('Y-m-d H:i:s') . "'
			)";

		DB::write($query);
	}

	public function hide(): void
	{
		$query =
			"UPDATE messages 
			SET is_hidden = 1 
			WHERE id = " . $this->id . " LIMIT 1";

		DB::write($query);
	}

	public function markAsRead(): void
	{
		$query =
			"UPDATE messages 
			SET is_read = 1 
			WHERE id = " . $this->id . " LIMIT 1";

		DB::write($query);
	}

	public function exists(): bool
	{
		return null !== $this->id;
	}
}
