<?php

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


    public function validateCreate(): string
	{
		if ($this->user->username === '') {
			return 'Invalid username!';
		}
		
		if (!filter_var($this->user->email, FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email!';
		}
		
		if ($this->user->password === '') {
			return 'Invalid password!';
		}
		
		if (!isset(User::ROLES[$this->user->roleId])) {
			return 'Invalid role!';
		}

		$user = $this->userRepository->findOneByUsernameOrEmail(
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
        
        if (!isset(User::ROLES[$this->user->roleId])) {
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

        $otherUser = $this->userRepository->findOtherByUsernameOrEmail(
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
