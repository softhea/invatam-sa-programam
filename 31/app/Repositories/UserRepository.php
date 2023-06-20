<?php

namespace App\Repositories;

use Core\Database\DB;
use App\Models\User;

class UserRepository
{
    public function find(int $id): User
    {
        $query = "SELECT * FROM users WHERE id = ".$id;
        
        return DB::readOne($query, User::class);
    }

    public function findOneByUsernameOrEmail(string $username, string $email): User
    {
        $query = "SELECT * FROM users WHERE username = '".$username."' OR email = '".$email."'";

        return DB::readOne($query, User::class);
    }

    public function findOnebyUsernameAndPassword(string $username, string $password): User
    {
        $query = 
            "SELECT * FROM users 
            WHERE username = '".$username."' 
            AND password = '".md5($password)."'";
        
            return DB::readOne($query, User::class);
    }

    public function findOneByRegisterCode(?string $registerCode): User
    {
        $query = "SELECT * FROM users WHERE register_code = '".$registerCode."'";

        return DB::readOne($query, User::class);
    }

    public function findOtherByUsernameOrEmail(int $id, string $username, string $email): User
    {        
        $query = 
            "SELECT * FROM users 
            WHERE 
                (username = '".$username."' OR email = '".$email."') AND 
                id != ".$id;

        return DB::readOne($query, User::class);
    }

    public function findByLoggedUser(User $user): array
    {
        $where = "";
        if ($user->roleId === User::ROLE_ID_USER) {
            $where = " WHERE role_id = ".User::ROLE_ID_USER;	
        } elseif ($user->roleId === User::ROLE_ID_ADMIN) {
            $where = " WHERE role_id >= ".User::ROLE_ID_ADMIN;	
        }

        $query = "SELECT * FROM users ".$where;

        return DB::readAll($query, User::class);
    }
}
