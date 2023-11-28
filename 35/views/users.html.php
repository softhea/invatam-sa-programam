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

<table class="table table-striped" id="table-users">
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
	<tbody></tbody>
</table>

<script>
	fetch('<?=HOME_URL?>/api/users')
		.then(function (response) {
			return response.json();
		}).then(
			function (users) {
				users.forEach(user => {
					let userHtml = 
						'<tr>' +
							'<td>' + user.id + '</td>' +
							'<td>' + user.username + '</td>' +	
							'<td>' + user.email + '</td>' +	
							'<td>' + user.role + '</td>' +	
							'<td>' + (user.isActive ? 'Yes' : 'No') + '</td>' +
							'<td><a href="send-message?user_id=' + user.id + '" class="btn btn-info">Send Message</a></td>' +
							'<td>' + 
								(
									user.canBeUpdated 
										? '<a href="update-user?id=' + user.id + '" class="btn btn-warning">Edit</a>' 
										: ''
								) + ' ' +
								(
									user.canBeDeleted
										? '<a href="delete-user?id=' + user.id + '" class="delete-button btn btn-danger">Delete</a>' 
										: ''
								) +
							'</td>' +
						'</tr>';
					document.getElementById('table-users').getElementsByTagName('tbody')[0].insertAdjacentHTML("beforeend", userHtml);
				});
			}
		);
</script>

<?php 
include 'views/footer.html.php';
?>