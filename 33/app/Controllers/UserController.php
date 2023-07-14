<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Core\Auth;
use Exception;

class UserController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        redirectIfNotLogged();

        $this->userRepository = new UserRepository();
    }

    public function list()
    {
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        $error = isset($_GET['error']) ? $_GET['error'] : '';
        
        $users = $this->userRepository->findByLoggedUser(Auth::user());
        
        include 'views/users.html.php';
    }

    public function createForm()
    {
        $error = $_GET['error'] ?? '';
        $username = $_GET['username'] ?? '';
        $email = $_GET['email'] ?? '';
        $roleId = isset($_GET['role_id']) ? (int)$_GET['role_id'] : User::ROLE_ID_USER;
        
        include 'views/add-user.html.php';
    }

    public function create()
    {
        $user = new User($_POST);
        $userValidator = new UserValidator($user);
        
        try {
            $userValidator->validateCreate();
        } catch (Exception $exception) {
            redirect(
                'create-user?error='.$exception->getMessage().
                '&username='.$user->username.
                '&email='.$user->email.
                '&roleId='.$user->roleId
            );	
        }
    
        $user->save();

        redirect('users?message=User created successfuly');	
    }

    public function delete()
    {
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

        try {
            $userValidator->validateUpdate($user);
        } catch (Exception $exception) {
            redirect(
                'update-user?id='.$id.
                '&error='.$exception->getMessage().
                '&username='.$newUser->username.
                '&email='.$newUser->email.
                '&role_id='.$newUser->roleId
            );
        }
        
        $user->username = $newUser->username;
        $user->email = $newUser->email;
        $user->roleId = $newUser->roleId;
        if (null !== $userValidator->password) {
            $user->password = $userValidator->password;
        }

        $user->save();

        redirect('users?message=User '.$user->username.' has been updated!');
    }
}
