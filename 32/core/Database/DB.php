<?php

namespace Core\Database;

class DB
{
    private static $connection = null;

    private static function connect()
    {
        if (null !== self::$connection && false !== self::$connection) {
            return;
        }

        // dump('connecting to DB...');

        self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    private static function getConnection()
    {
        self::connect();

        return self::$connection;
    }

    public static function readAll(string $query, string $className): array
    {
        dump($query);

        $result = mysqli_query(self::getConnection(), $query);

        $users = [];
        while ($user = mysqli_fetch_assoc($result)) {
            $users[] = new $className($user);
        }
        
        return $users;
    }

    public static function readOne(string $query, string $className)
    {
        dump($query);

        $result = mysqli_query(self::getConnection(), $query);

        return new $className(mysqli_fetch_assoc($result));
    }

    public static function write(string $query): void
    {
        dump($query);

        mysqli_query(self::getConnection(), $query);
    }
}
