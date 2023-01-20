<?php

require 'includes/common.php';

redirectIfNotLogged();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$userRepository = new UserRepository();
$user = $userRepository->find($userId);
if (null !== $user->id) {
    $user->delete();
}

redirect('users.php');
