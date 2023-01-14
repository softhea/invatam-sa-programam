<?php 
include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1 id="user-title">Messages</h1>

<?php if (count($messages) > 0): ?>
	<table border="1">
		<tr>
			<th>Sender</th>
			<th>Receiver</th>
			<th>Message</th>
			<th>Date And Time</th>
			<th>Is Read</th>
			<th>Hide</th>
		</tr>

		<?php foreach ($messages as $message): ?>
			<tr>
				<td><?=$message['sender']?></td>
				<td><?=$message['receiver']?></td>
				<td><?=$message['message']?></td>
				<td><?=$message['date_and_time']?></td>
				<td><?=(int)$message['is_read'] === 1 ? 'Yes' : 'No'?></td>
				<td>
					<?php if ((int)$message['receiver_id'] === $loggedUserId): ?>
						<a href="hide-message.php?id=<?=$message['id']?>">Hide</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php 
include 'views/footer.html.php';
?>