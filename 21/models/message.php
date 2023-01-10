<?php

function sendMessage(int $userId, string $message): void
{
	global $databaseConnection, $loggedUserId;
	
	$query = 
		"INSERT INTO messages (sender_id, receiver_id, message, is_read, date_and_time) 
		VALUES (".$loggedUserId.", ".$userId.", '".$message."', 0, '".date('Y-m-d H:i:s')."')";
	mysqli_query($databaseConnection, $query);
}

function getMessages(): array
{
	global $databaseConnection, $loggedUserId;

	$query = 
		"SELECT m.*, s.username AS sender, r.username AS receiver 
		FROM messages m
		JOIN users s ON m.sender_id = s.id
		JOIN users r ON m.receiver_id = r.id		
		WHERE m.sender_id = ".$loggedUserId." 
		OR (m.receiver_id = ".$loggedUserId." AND m.is_hidden = 0)";

	$result = mysqli_query($databaseConnection, $query);

	$messages = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$messages[] = $row;
	}
	
	return $messages;
}

function hideMessage(int $id): void
{
	global $databaseConnection, $loggedUserId;
	
	$query = 
		"UPDATE messages 
		SET is_hidden = 1 
		WHERE receiver_id = ".$loggedUserId." 
		AND id = ".$id;
		
	mysqli_query($databaseConnection, $query);
}

function markMessagesAsRead(array $messageIds): void
{
	global $databaseConnection, $loggedUserId;
	
	$messageIds = implode(',', $messageIds);
	$query = 
		"UPDATE messages 
		SET is_read = 1 
		WHERE receiver_id = ".$loggedUserId." 
		AND id IN (".$messageIds.")";
		
	mysqli_query($databaseConnection, $query);
}
