<?php

session_start();

$error = '';
if (isset($_POST['login'])) {
	$query = "SELECT id, register_code FROM users WHERE username = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";

    	$databaseConnection = mysqli_connect('localhost', 'root', '', 'invatam_sa_programam');
	$result = mysqli_query($databaseConnection, $query);
	$user = mysqli_fetch_assoc($result);
	if ($user !== null) {
		if ($user['register_code'] === null) {
			$_SESSION['logged'] = true;	
			$_SESSION['username'] = $_POST['username'];		
		} else {
			$error = 'Please confirm registration by clicking on the link you received at your email address!';	
		}
	} else {
		$error = 'Invalid credentials!';
	}
}

include 'menu.php';
?>

<?php if (!$logged): ?>
	<form method="POST">
		<input type="text" name="username" value="" placeholder="Username">
		<input type="password" name="password" value="" placeholder="Password">
		<input type="submit" name="login" value="Login">
		<a href="register.php">Register</a>
	</form>

	<?php if ($error !== ''): ?>
		<p><?=$error?></p>
	<?php endif; ?>

<?php endif; ?>

<?php if (isset($_GET['message'])): ?>
	<p><?=$_GET['message']?></p>
<?php endif; ?>

<h1>Invatam Sa Programam</h1>

<h3>PHP & MySQL</h3>

<p>HTML</p>
