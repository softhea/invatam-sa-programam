<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Core\Auth;
use Exception;

class AuthController
{
    public function loginForm()
    {
        redirectIfLogged();

        $error = isset($_GET['error']) ? $_GET['error'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        include 'views/login.html.php';
    }

    public function login()
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findOneByUsernameAndPassword(
            $_POST['username'], 
            $_POST['password']
        );

        if (!$user->exists()) {
            redirect('login?error=Invalid credentials!');
        }

        if ($user->isActive()) {
            Auth::login($user);
            
            redirect(HOME_URL);
        }
        
        $error = 
            'Please confirm registration by clicking on the link'.
            ' you received at your email address!';	

        redirect('login?error='.$error);
    }

    public function logout()
    {
        Auth::logout();

        redirect(HOME_URL);
    }

    public function registerForm()
    {
        redirectIfLogged();

        $username = $_GET['username'] ?? '';
        $email = $_GET['email'] ?? '';
        $error = $_GET['error'] ?? '';

        include 'views/register.html.php';
    }    

    public function register()
    {
        $user = new User($_POST);
        $user->roleId = User::ROLE_ID_USER;
        
        $userValidator = new UserValidator($user);
        
        try {
            $userValidator->validateCreate();
        } catch (Exception $exception) {
            redirect(
                'register?error='.$exception->getMessage().
                '&username='.$user->username.
                '&email='.$user->email
            );
        }
    
        $registerCode = md5(time().rand(100000, 999999));
        $user->registerCode = $registerCode;

        $user->save();

        $link = HOME_URL.'/confirm?register_code='.$registerCode;

        mail(
            $user->email, 
            'Invatam Sa Programam Registration Confirmation', 
            'Click on: '.$link.' to finalize registration!'
        );
            
        redirect('login?message=Please check email and click on received link to confirm registration!');
    } 

    public function confirm()
    {
        redirectIfLogged();

        $registerCode = $_GET['register_code'] ?? '';

        $userRepository = new UserRepository();
        $user = $userRepository->findOneByRegisterCode($registerCode);
        if (!$user->exists()) {
            redirect('login?error=Invalid register code!');	
        } 
        $user->activate();

        redirect('login?message=User has been activated successfully.');
    }
}
