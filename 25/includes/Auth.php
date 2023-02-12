<?php

session_start();

class Auth
{
    public static ?User $user = null;

    public static function isLogged(): bool
    {
        return null !== self::$user;
    }

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            return;
        } 
        
        $userRepository = new UserRepository();
        $user = $userRepository->find((int)$_SESSION['user_id']);
        if (!$user->exists()) {
            return;
        }

        self::$user = $user;
    }
}
