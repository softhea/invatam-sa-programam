<?php

class User 
{
	public ?int $id = null;
	public ?string $username = null;
	public ?string $email = null;
	public ?string $password = null;
	public ?string $registerCode = null;
	public ?int $roleId = null;
	
	public function __construct(array $user = [])
	{
		if (isset($user['id'])) {
			$this->id = (int)$user['id'];	
		}
		if (isset($user['username'])) {
			$this->username = trim($user['username']);
		}
		if (isset($user['email'])) {
			$this->email = trim($user['email']);
		}
		if (isset($user['password'])) {
			$this->password = trim($user['password']);
		}
		if (isset($user['register_code'])) {
			$this->registerCode = trim($user['register_code']);
		}
		if (isset($user['role_id'])) {
			$this->roleId = (int)$user['role_id'];
		}
	}
	
	public function create(): string
	{
		if ($this->username === '') {
			return 'Invalid username!';
		}
		
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email!';
		}
		
		if ($this->password === '') {
			return 'Invalid password!';
		}
		
		if ($this->roleId === 0) {
			return 'Invalid role!';
		}
		
		$user = findUserByUsernameOrEmail($this->username, $this->email);
		if ($user !== null) {
			return 'User Already Exists!';
		}
		
		$this->createUser();
		
		return '';
	}
	
	private function createUser(): void
	{
		global $databaseConnection;
		
		$query = 
			"INSERT INTO users (username, email, password, register_code, role_id) 
			VALUES ('".$this->username."', '".$this->email."', '".md5($this->password)."', NULL, ".$this->roleId.")";
		mysqli_query($databaseConnection, $query);
	}
}
	