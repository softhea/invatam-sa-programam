<?php

require 'includes/common.php';

redirectIfNotLogged();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (0 !== $id) {
	hideMessage($id);	
}

redirect('messages.php');
