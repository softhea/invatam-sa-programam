<?php

class DB
{
    private static $connection = null;

    private static function connect()
    {
        if (null !== self::$connection && false !== self::$connection) {
            return;
        }

        dump('connecting to DB...');

        self::$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public static function readAll(string $query, string $className): array
    {
        self::connect();

        dump($query);

        $result = mysqli_query(self::$connection, $query);

        $users = [];
        while ($user = mysqli_fetch_assoc($result)) {
            $users[] = new $className($user);
        }
        
        return $users;
    }

    public static function readOne(string $query, string $className)
    {
        self::connect();

        dump($query);

        $result = mysqli_query(self::$connection, $query);

        return new $className(mysqli_fetch_assoc($result));
    }

    public static function write(string $query): void
    {
        self::connect();

        dump($query);

        mysqli_query(self::$connection, $query);
    }
}
