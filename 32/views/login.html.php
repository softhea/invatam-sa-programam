<?php 
include 'views/header.html.php';
?>

<form method="POST" action="login">
	<input type="text" name="username" value="" placeholder="Username">
	<input type="password" name="password" value="" placeholder="Password">
	<input type="submit" name="login" value="Login">
	<a href="register">Register</a>
</form>

<?php if ($message !== ''): ?>
	<p class="message"><?=$message?></p>
<?php endif; ?>

<?php if ($error !== ''): ?>
	<p class="error"><?=$error?></p>
<?php endif; ?>

<?php 
include 'views/footer.html.php';
?>