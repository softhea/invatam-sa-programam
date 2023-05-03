<?php

use App\Repositories\UserRepository;

require 'includes/common.php';

redirectIfLogged();

$registerCode = $_GET['register_code'];

$userRepository = new UserRepository();
$user = $userRepository->findOneByRegisterCode($registerCode);
if (!$user->exists()) {
	redirect('login.php?error=Invalid register code!');	
} 
$user->activate();

redirect('login.php?message=User has been activated successfully.');
