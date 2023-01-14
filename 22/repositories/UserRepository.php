<?php

class UserRepository
{
    function find(int $id): ?User
    {
        global $databaseConnection;
        
        $query = "SELECT * FROM users WHERE id = ".$id;
        $result = mysqli_query($databaseConnection, $query);
        
        return new User(mysqli_fetch_assoc($result));
    }

    function findOneByUsernameOrEmail(string $username, string $email): User
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
}
