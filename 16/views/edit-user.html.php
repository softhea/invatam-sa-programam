<h1>Edit User <?=$username?></h1>

<form method="POST">
	<input type="text" name="username" value="<?=$username?>" placeholder="Username"><br>
	<br>
	<input type="text" name="email" value="<?=$email?>" placeholder="Email Address"><br>
	<br>
	<select name="role_id">
		<?php foreach ($roles as $roleId => $roleName): ?>
			<?php 
				if (
					$_SESSION['role_id'] <= $roleId &&
					$roleId !== 1
				): 
			?>
				<option value="<?=$roleId?>" 
					<?php if ((int)$user['role_id'] === $roleId): ?> selected <?php endif; ?>
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
