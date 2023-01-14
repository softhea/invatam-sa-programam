<?php

class UserValidator
{
    private ?User $user = null;
    public ?string $password = null;

    public function __construct(User $user = null)
	{
        $this->user = $user;
	}

    public function validateCreate(): string
	{
        global $roles;

		if ($this->user->username === '') {
			return 'Invalid username!';
		}
		
		if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email!';
		}
		
		if ($this->user->password === '') {
			return 'Invalid password!';
		}
		
		if (!isset($roles[$this->user->roleId])) {
			return 'Invalid role!';
		}

        $userRepository = new UserRepository();
		$user = $userRepository->findOneByUsernameOrEmail(
            $this->user->username, 
            $this->user->email
        );
		if ($user->id !== null) {
			return 'User Already Exists!';
		}

		return '';
	}

    public function validateUpdate(User $oldUser): string
    {
        global $roles;

        if ($this->user->username === '') {
			return 'Invalid username!';
		}

        if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email!';
        }

        if (
            $this->user->password !== '' && 
            md5($this->user->password) !== $oldUser->password
        ) {
            $this->password = md5($this->user->password);
        }
        
        if (!isset($roles[$this->user->roleId])) {
            return 'Invalid role!';
        }
         
        if (
            $oldUser->username === $this->user->username &&
            $oldUser->email === $this->user->email &&
            $oldUser->roleId === $this->user->roleId &&
            null === $this->password
        ) {
            return 'No update!';
        }

        $userRepository = new UserRepository();
        $otherUser = $userRepository->findOtherByUsernameOrEmail(
            $oldUser->id, 
            $this->user->username, 
            $this->user->email
        );
        if ($otherUser->id !== null) {
            return 'User Already Exists!';
        }

        return '';
    }
}
