<?php 
include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1>Send Message to <?=$username?></h1>

<form method="POST" action="">
	<textarea rows="4" cols="50" name="message"></textarea>
	<br>
	<input type="submit" name="send" value="Send">
</form>	