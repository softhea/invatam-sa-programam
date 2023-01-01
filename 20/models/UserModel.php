<?php

class User 
{
	public int $id;
	public string $username;
	public string $email;
	public ?string $registerCode;
	public int $roleId;
	
	public function __construct(array $user)
	{
		$this->id = (int)$user['id'];
		$this->username = $user['username2'];
		$this->email = $user['email'];
		$this->registerCode = $user['register_code'];
		$this->roleId = (int)$user['role_id'];
	}
}
	