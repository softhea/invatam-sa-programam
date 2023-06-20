<?php

namespace App\Validators;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserValidator
{
    private ?User $user = null;
    private UserRepository $userRepository;
    public ?string $password = null;

    public function __construct(User $user = null)
	{
        $this->user = $user;
        $this->userRepository = new UserRepository();
	}

    public function validateCreate(): void
	{
		if ($this->user->username === '') {
			throw new Exception('Invalid username!');
		}
		
		if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email!');
		}
		
		if ($this->user->password === '') {
            throw new Exception('Invalid password!');
		}
		
		if (!isset(User::ROLES[$this->user->roleId])) {
            throw new Exception('Invalid role!');
		}

		$user = $this->userRepository->findOneByUsernameOrEmail(
            $this->user->username, 
            $this->user->email
        );
		if ($user->id !== null) {
            throw new Exception('User Already Exists!');
		}
	}

    public function validateUpdate(User $oldUser): void
    {
        if ($this->user->username === '') {
            throw new Exception('Invalid username!');
		}

        if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email!');
        }

        if (
            $this->user->password !== '' && 
            md5($this->user->password) !== $oldUser->password
        ) {
            $this->password = md5($this->user->password);
        }
        
        if (!isset(User::ROLES[$this->user->roleId])) {
            throw new Exception('Invalid role!');
        }
         
        if (
            $oldUser->username === $this->user->username &&
            $oldUser->email === $this->user->email &&
            $oldUser->roleId === $this->user->roleId &&
            null === $this->password
        ) {
            throw new Exception('No update!');
        }

        $otherUser = $this->userRepository->findOtherByUsernameOrEmail(
            $oldUser->id, 
            $this->user->username, 
            $this->user->email
        );
        if ($otherUser->id !== null) {
            throw new Exception('User Already Exists!');
        }
    }
}
