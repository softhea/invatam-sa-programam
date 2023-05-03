<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use Core\Auth;

class UserController
{
    public function list()
    {
        redirectIfNotLogged();

        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        
        $userRepository = new UserRepository();
        $users = $userRepository->findByLoggedUser(Auth::user());
        
        include 'views/users.html.php';
    }
}
