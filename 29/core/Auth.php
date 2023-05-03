<?php

namespace Core;
use App\Repositories\UserRepository;

session_start();

use App\Models\User;

class Auth
{
    private static ?User $user = null;

    public static function login(User $user): void
    {
        $_SESSION['logged_user_id'] = $user->id;
    }

    public static function logout(): void
    {
        unset($_SESSION['logged_user_id']);
        self::$user = null;
    }

    public static function isLogged(): bool
    {
        return isset($_SESSION['logged_user_id']);
    }

    public static function user(): User
    {
        if (null !== self::$user) {
            return self::$user;
        }
        
        if (!self::isLogged()) {
            return new User();
        }

        $userRepository = new UserRepository();

        $user = $userRepository->find((int)$_SESSION['logged_user_id']);
        if ($user->exists()) {
            self::$user = $user;
        }

        return self::$user;
    }

    public static function id(): ?int
    {
        if (!self::isLogged()) {
            return null;
        }

        return (int)$_SESSION['logged_user_id'];
    }
}
