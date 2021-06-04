<h1>Users</h1>

<?php if ($_SESSION['role_id'] <= 2): ?>
<p><a href="add-user.php">Add New User</a></p>
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
			<th>Actions</th>
		</tr>

		<?php foreach ($users as $user): ?>
			<tr>
				<td><?=$user['id']?></td>
				<td><?=$user['username']?></td>
				<td><?=$user['email']?></td>
				<td><?=$roles[$user['role_id']]?></td>
				<td><?=$user['register_code'] === null ? 'Yes' : 'No'?></td>
				<td>
					<?php 
						if (
							$_SESSION['role_id'] < $user['role_id'] ||
							$_SESSION['username'] === $user['username']
						): 
					?>
						<a href="edit-user.php?user_id=<?=$user['id']?>" >Edit</a>
					<?php endif; ?>
					<?php if ($_SESSION['role_id'] < $user['role_id']): ?>
						<a href="delete-user.php?user_id=<?=$user['id']?>" 
							onclick="return confirm('Are you sure you want to delete the user?')">Delete
						</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>
