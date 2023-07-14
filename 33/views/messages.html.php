<?php

use Core\Auth;

include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1 id="user-title">Messages</h1>

<?php if (count($messages) > 0): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Sender</th>
				<th>Receiver</th>
				<th>Message</th>
				<th>Date And Time</th>
				<th>Is Read</th>
				<th>Hide</th>
			</tr>
		</thead>

		<?php foreach ($messages as $message): ?>
			<tr>
				<td><?=$message->sender?></td>
				<td><?=$message->receiver?></td>
				<td><?=nl2br($message->message)?></td>
				<td><?=$message->dateAndTime?></td>
				<td><?=$message->isRead ? 'Yes' : 'No'?></td>
				<td>
					<?php if ($message->receiverId === Auth::id()): ?>
						<a href="hide-message?id=<?=$message->id?>">Hide</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

<?php else: ?>
	<div class="alert alert-info" role="alert">
		No messages!
	</div>

<?php endif; ?>

<?php if ($error !== ''): ?>
	<p class="error"><?=$error?></p>
<?php endif; ?>

<?php if ($response !== ''): ?>
	<p class="message"><?=$response?></p>
<?php endif; ?>

<?php 
include 'views/footer.html.php';
?>