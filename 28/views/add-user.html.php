<?php

use App\Models\User;
use Core\Auth;

include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1>Add New User</h1>

<form method="POST">
	<input type="text" name="username" value="<?=$username?>" placeholder="Username"><br>
	<br>
	<input type="text" name="email" value="<?=$email?>" placeholder="Email Address"><br>
	<br>
	<select name="role_id">
		<?php foreach (User::ROLES as $id => $roleName): ?>
			<?php 
				if (
					Auth::user()->roleId <= $id &&
					$id !== User::ROLE_ID_SUPER_ADMIN
				): 
			?>
				<option value="<?=$id?>" 
					<?php if ($id === $roleId) echo 'selected'; ?> 
				><?=$roleName?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select><br>
	<br>
	<input type="password" name="password" value="" placeholder="Password"><br>
	<br>
	<input type="submit" name="save" value="Save">
</form>
<?php if ($error !== ''): ?>
	<p><?=$error?></p>
<?php endif; ?>

<?php
include 'views/footer.html.php';
?>