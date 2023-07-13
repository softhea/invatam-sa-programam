<?php

use Core\Auth;

include 'views/header.html.php';
if (Auth::isLogged()) {
    include 'views/menu.html.php';
}
?>

<h1>Page Not Found!</h1>

<?php
include 'views/footer.html.php';
?>