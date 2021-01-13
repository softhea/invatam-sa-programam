<?php

/**
 * creates database `invatam_sa_programam` if it doesn't exist
 */
$databaseConnection = mysqli_connect('localhost', 'root', '');
if ($databaseConnection !== false) {
    /**
     * searches for 'invatam_sa_programam' database
     */
    $query = "SHOW DATABASES WHERE `DATABASE` = 'invatam_sa_programam'";
    $result = mysqli_query($databaseConnection, $query);
    $database = mysqli_fetch_assoc($result);
    if ($database === null) {
        $query = "CREATE DATABASE invatam_sa_programam DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
        mysqli_query($databaseConnection, $query);
        $affectedRows = mysqli_affected_rows($databaseConnection);
        if ($affectedRows < 1) {
            die('Database `invatam_sa_programam` could not be created!');
        }
    }
} else {
    die('Could not connect to MySQL Server!');
}

/**
 * closes the current connection. creates a new one that uses the database too
 * this connection will be used in index.php too
 */
mysqli_close($databaseConnection);
$databaseConnection = mysqli_connect('localhost', 'root', '', 'invatam_sa_programam');

/**
 * creates table `users` if it doesn't exist
 */
$query =
    "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(10) UNSIGNED NOT NULL,
        `username` varchar(50) NOT NULL,
        `password` varchar(20) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$result = mysqli_query($databaseConnection, $query);
if ($result === false) {
    die('Could not create table `users`!');
}

/**
 * adds indexes for `id` and `username` columns: PRIMARY KEY for `id` and KEY for `username`
 */
$query =
    "ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`)";
$result = mysqli_query($databaseConnection, $query);
if ($result !== false) {
    /**
     * adds AUTO_INCREMENT for `id` column
     */
    $query =
        "ALTER TABLE `users`
        MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
    mysqli_query($databaseConnection, $query);
}

/**
 * inserts two admin users if user with 'admin' username doesn't exist
 */
$query = "SELECT id FROM users WHERE username = 'admin'";
$result = mysqli_query($databaseConnection, $query);
if (mysqli_num_rows($result) === 0) {
    $query =
        "INSERT INTO `users` (
            `username`, `password`
        ) VALUES
            ('admin', 'parola'),
            ('admin2', 'parola2')";
    mysqli_query($databaseConnection, $query);
}
