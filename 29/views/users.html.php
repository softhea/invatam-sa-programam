<?php

use App\Models\User;
use Core\Auth;

include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1 id="user-title">Users</h1>

<?php if (Auth::user()->roleId <= User::ROLE_ID_ADMIN): ?>
<p><a href="add-user.php" id="user-add-new">Add New User</a></p>
<?php endif; ?>

<?php if ($error !== ''): ?>
	<p class="error"><?=$error?></p>
<?php endif; ?>

<?php if ($message !== ''): ?>
	<p class="message"><?=$message?></p>
<?php endif; ?>

<?php if (count($users) > 0): ?>
	<table border="1">
		<tr>
			<th>User ID</th>
			<th>Username</th>
			<th>Email</th>
			<th>Role</th>
			<th>Active</th>
			<th>Send Message</th>
			<th>Actions</th>
		</tr>

		<?php foreach ($users as $user): ?>
			<tr>
				<td><?=$user->id?></td>
				<td class="user-username"><?=$user->username?></td>
				<td class="user-email"><?=$user->email?></td>
				<td><?=User::ROLES[$user->roleId]?></td>
				<td><?=$user->registerCode === null ? 'Yes' : 'No'?></td>
				<td><a href="send-message.php?user_id=<?=$user->id?>">Send Message</a></td>
				<td>
					<?php 
						if (
							Auth::user()->roleId < $user->roleId ||
							Auth::user()->username === $user->username
						): 
					?>
						<a href="edit-user.php?user_id=<?=$user->id?>" >Edit</a>
					<?php endif; ?>
					<?php if (Auth::user()->roleId < $user->roleId): ?>
						<a href="delete-user.php?user_id=<?=$user->id?>" 
							onclick="return confirm('Are you sure you want to delete the user?')">Delete
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php 
include 'views/footer.html.php';
?>