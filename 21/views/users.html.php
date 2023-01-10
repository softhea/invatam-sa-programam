<?php 
include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1 id="user-title">Users</h1>

<?php if ($_SESSION['role_id'] <= 2): ?>
<p><a href="add-user.php" id="user-add-new">Add New User</a></p>
<?php endif; ?>

<?php if ($message !== ''): ?>
	<p><?=$message?></p>
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
				<td><?=$roles[$user->roleId]?></td>
				<td><?=$user->registerCode === null ? 'Yes' : 'No'?></td>
				<td><a href="send-message.php?user_id=<?=$user->id?>">Send Message</a></td>
				<td>
					<?php 
						if (
							$_SESSION['role_id'] < $user->roleId ||
							$_SESSION['username'] === $user->username
						): 
					?>
						<a href="edit-user.php?user_id=<?=$user->id?>" >Edit</a>
					<?php endif; ?>
					<?php if ($_SESSION['role_id'] < $user->roleId): ?>
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