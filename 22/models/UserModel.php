<?php

class User 
{
	public ?int $id = null;
	public ?string $username = null;
	public ?string $email = null;
	public ?string $password = null;
	public ?string $registerCode = null;
	public ?int $roleId = null;

	private array $originals = [];
	
	public function __construct(?array $user = [])
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
			$this->originals['password'] = $this->password;
		}
		if (isset($user['register_code'])) {
			$this->registerCode = trim($user['register_code']);
		}
		if (isset($user['role_id'])) {
			$this->roleId = (int)$user['role_id'];
		}
	}

	public function save(): void
	{
		global $databaseConnection;
		
		if (null === $this->id) {
			$query = 
				"INSERT INTO users (username, email, password, register_code, role_id) 
				VALUES (
					'".$this->username."', 
					'".$this->email."', 
					'".md5($this->password)."', 
					NULL, 
					".$this->roleId."
				)";
		} else {
			$updatePassword = '';
			if ($this->password !== $this->originals['password']) {
				$updatePassword = " , password = '".$this->password."'";
			}
			$query = 
				"UPDATE users SET 
					username = '".$this->username."'
					, email = '".$this->email."'
					, role_id = '".$this->roleId."'
					".$updatePassword."
				WHERE id = ".$this->id;
		}
	
		mysqli_query($databaseConnection, $query);
	}
}
	