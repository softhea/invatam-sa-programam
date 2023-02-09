<?php

class User 
{
	const ROLE_ID_SUPER_ADMIN = 1;
	const ROLE_ID_ADMIN = 2;
	const ROLE_ID_USER = 3;

	const ROLES = [
		self::ROLE_ID_SUPER_ADMIN => 'Super Admin',
		self::ROLE_ID_ADMIN => 'Admin',
		self::ROLE_ID_USER => 'User',
	];

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
			$this->originals['register_code'] = $this->registerCode;
		}
		if (isset($user['role_id'])) {
			$this->roleId = (int)$user['role_id'];
		}
	}

	public function save(): void
	{
		DB::write($this->getSaveQuery());
	}

	private function getSaveQuery(): string
	{
		if (null === $this->id) {
			return
				"INSERT INTO users (username, email, password, register_code, role_id) 
				VALUES (
					'".$this->username."', 
					'".$this->email."', 
					'".md5($this->password)."', 
					NULL, 
					".$this->roleId."
				)";
		}

		$updatePassword = '';
		if ($this->password !== $this->originals['password']) {
			$updatePassword = " , password = '".$this->password."' ";
		}

		$updateRegisterCode = '';
		if ($this->registerCode !== $this->originals['register_code']) {
			if (null === $this->registerCode) {
				$updateRegisterCode = " , register_code = NULL ";	
			} else {
				$updateRegisterCode = " , register_code = '".$this->registerCode."' ";
			}
		}

		return 
			"UPDATE users SET 
				username = '".$this->username."'
				, email = '".$this->email."'
				, role_id = '".$this->roleId."'
				".$updatePassword."
				".$updateRegisterCode."
			WHERE id = ".$this->id;
	}

	public function delete(): void
	{		
		$query = "DELETE FROM users WHERE id = ".$this->id;

		DB::write($query);
	}
}
	
