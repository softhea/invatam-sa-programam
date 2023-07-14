<?php

use App\Models\User;
use Core\Auth;

include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1>Users</h1>

<?php if (Auth::user()->roleId <= User::ROLE_ID_ADMIN): ?>
	<p>
		<a href="create-user" class="btn btn-primary">Add New User</a>
	</p>
<?php endif; ?>

<?php if ($error !== ''): ?>
	<p class="error"><?=$error?></p>
<?php endif; ?>

<?php if ($message !== ''): ?>
	<p class="message"><?=$message?></p>
<?php endif; ?>

<?php if (count($users) > 0): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>User ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Role</th>
				<th>Active</th>
				<th>Send Message</th>
				<th>Actions</th>
			</tr>
		</thead>

		<?php foreach ($users as $user): ?>
			<tr>
				<td><?=$user->id?></td>
				<td class="user-username"><?=$user->username?></td>
				<td class="user-email"><?=$user->email?></td>
				<td><?=User::ROLES[$user->roleId]?></td>
				<td><?=$user->registerCode === null ? 'Yes' : 'No'?></td>
				<td><a href="send-message?user_id=<?=$user->id?>" class="btn btn-info">Send Message</a></td>
				<td>
					<?php 
						if (
							Auth::user()->roleId < $user->roleId ||
							Auth::user()->username === $user->username
						): 
					?>
						<a href="update-user?id=<?=$user->id?>" class="btn btn-warning">Edit</a>
					<?php endif; ?>
					<?php if (Auth::user()->roleId < $user->roleId): ?>
						<a href="delete-user?id=<?=$user->id?>" class="delete-button btn btn-danger">Delete</a>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php 
include 'views/footer.html.php';
?>