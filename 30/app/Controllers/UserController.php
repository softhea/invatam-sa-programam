<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Core\Auth;

class UserController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function list()
    {
        redirectIfNotLogged();

        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        
        $users = $this->userRepository->findByLoggedUser(Auth::user());
        
        include 'views/users.html.php';
    }

    public function createForm()
    {
        redirectIfNotLogged();

        $error = $_GET['error'] ?? '';
        $username = $_GET['username'] ?? '';
        $email = $_GET['email'] ?? '';
        $roleId = isset($_GET['role_id']) ? (int)$_GET['role_id'] : User::ROLE_ID_USER;
        
        include 'views/add-user.html.php';
    }

    public function create()
    {
        redirectIfNotLogged();

        $user = new User($_POST);
        $userValidator = new UserValidator($user);
        $error = $userValidator->validateCreate();
        if ('' === $error) {
            $user->save();
            redirect('users?message=User created successfuly');	
        }
        
        redirect(
            'create-user?error='.$error.
            '&username='.$user->username.
            '&email='.$user->email.
            '&roleId='.$user->roleId
        );	
    }

    public function delete()
    {
        redirectIfNotLogged();

        $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $user = $this->userRepository->find($userId);
        if (!$user->exists()) {
            redirect('users?error=User not found!');    
        }

        $user->delete();

        redirect('users?message=User deleted.');
    }

    public function updateForm()
    {
        redirectIfNotLogged();

        $error = $_GET['error'] ?? '';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $user = $this->userRepository->find($id);

        $username = $_GET['username'] ?? $user->username;
        $email = $_GET['email'] ?? $user->email;
        $currentRoleId = isset($_GET['role_id']) ? (int)$_GET['role_id'] : $user->roleId;

        if (!$user->exists()) {
            redirect('users?error=User not found!');
        }
        
        include 'views/edit-user.html.php';
    }

    public function update()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $user = $this->userRepository->find($id);

        $newUser = new User($_POST);
        $userValidator = new UserValidator($newUser);
        $error = $userValidator->validateUpdate($user);
        if ('' === $error) {
            $user->username = $newUser->username;
            $user->email = $newUser->email;
            $user->roleId = $newUser->roleId;
            if (null !== $userValidator->password) {
                $user->password = $userValidator->password;
            }
            $user->save();
    
            redirect('users?message=User '.$user->username.' has been updated!');
        }

        redirect(
            'update-user?id='.$id.
            '&error='.$error.
            '&username='.$newUser->username.
            '&email='.$newUser->email.
            '&role_id='.$newUser->roleId
        );
    }
}
