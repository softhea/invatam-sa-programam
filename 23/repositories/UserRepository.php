<?php

class UserRepository
{
    public function find(int $id): ?User
    {
        global $databaseConnection;
        
        $query = "SELECT * FROM users WHERE id = ".$id;
        $result = mysqli_query($databaseConnection, $query);
        
        return new User(mysqli_fetch_assoc($result));
    }

    public function findOneByUsernameOrEmail(string $username, string $email): User
    {
        global $databaseConnection;
        
        $query = "SELECT * FROM users WHERE username = '".$username."' OR email = '".$email."'";
        $result = mysqli_query($databaseConnection, $query);
        
        return new User(mysqli_fetch_assoc($result));
    }

    public function findOtherByUsernameOrEmail(int $id, string $username, string $email): User
    {
        global $databaseConnection;
        
        $query = 
            "SELECT * FROM users 
            WHERE 
                (username = '".$username."' OR email = '".$email."') AND 
                id != ".$id;

        $result = mysqli_query($databaseConnection, $query);
        
        return new User(mysqli_fetch_assoc($result));
    }

    public function findAll(): array
    {
        global $databaseConnection;
        
        $where = "";
        if ($_SESSION['role_id'] === User::ROLE_ID_USER) {
            $where = " WHERE role_id = ".User::ROLE_ID_USER;	
        } elseif ($_SESSION['role_id'] === User::ROLE_ID_ADMIN) {
            $where = " WHERE role_id >= ".User::ROLE_ID_ADMIN;	
        }

        $query = "SELECT id, username, email, register_code, role_id FROM users ".$where;

        $result = mysqli_query($databaseConnection, $query);

        $users = [];
        while ($user = mysqli_fetch_assoc($result)) {
            $users[] = new User($user);
        }
        
        return $users;
    }
}
