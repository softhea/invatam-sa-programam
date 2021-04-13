<?php 

session_start(); // gives me access to $_SESSION

unset($_SESSION['logged']); // unsets $_SESSION['logged']

header('location: index.php'); // redirects to index.php
exit;
