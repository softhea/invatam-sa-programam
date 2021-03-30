<?php

ini_set('display_errors', 1);

/**
 * create database if needed
 */
$databaseConnection = mysqli_connect('localhost', 'root', '');
if ($databaseConnection !== false) {
    $query = "SHOW DATABASES WHERE `DATABASE` = 'invatam_sa_programam'";
    $result = mysqli_query($databaseConnection, $query);
    $database = mysqli_fetch_assoc($result);
    if ($database === null) {
        $query = "CREATE DATABASE invatam_sa_programam DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
        $result = mysqli_query($databaseConnection, $query);
        $affectedRows = mysqli_affected_rows($databaseConnection);
        if ($affectedRows < 1) {
            die('database could not be created!');
        }
    }
} else {
    die('MySQL Server Details are incorrect!');
}

/**
 * use the database
 */
mysqli_close($databaseConnection);
$databaseConnection = mysqli_connect(
    'localhost',
    'root',
    '',
    'invatam_sa_programam'
);

/**
 * create table users if needed
 */
$query =
    "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(10) UNSIGNED NOT NULL,
    `username` varchar(50) NOT NULL,
    `password` varchar(20) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
$result = mysqli_query($databaseConnection, $query);
if ($result === false) {
    die('Error creating table users!');
}

/**
 * adds indexes for id and username
 */
$query =
    "ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
    ADD KEY `username` (`username`);";
$result = mysqli_query($databaseConnection, $query);
if ($result !== false) {
    /**
     * adds auto increment for id
     */
    $query =
        "ALTER TABLE `users`
        MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;";
    $result = mysqli_query($databaseConnection, $query);
}

/**
 * inserts admin users if needed
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
