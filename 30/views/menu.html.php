<?php

use Core\Auth;
?>
<p>
	<a href="index.php">Home</a>	
	<a href="users">Users</a>
	<a href="messages">Messages</a>
	<a href="logout">Logout</a>
	<span>Salut, <?=Auth::user()->username?>!</span>
</p>