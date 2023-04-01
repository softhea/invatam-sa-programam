<?php

use App\Repositories\UserRepository;

require 'includes/common.php';

redirectIfNotLogged();

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$userRepository = new UserRepository();
$user = $userRepository->find($userId);
if (!$user->exists()) {
    redirect('users.php?error=User not found!');    
}

$user->delete();

redirect('users.php?message=User deleted.');
