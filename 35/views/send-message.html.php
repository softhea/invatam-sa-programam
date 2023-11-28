<?php 
include 'views/header.html.php';
include 'views/menu.html.php';
?>

<h1>Send Message to <?=$user->username?></h1>

<form method="POST" action="send-message?user_id=<?=$userId?>">
	<textarea rows="4" cols="50" name="message"></textarea>
	<br>
	<input type="submit" name="send" value="Send">
</form>	

<?php 
include 'views/footer.html.php';
?>