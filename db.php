<?php

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbName = "db_name";

$error = "";

$link = mysqli_connect($servername, $username, $password);

if (!$link) {
    $error .= "Ошибка подключения: " . mysqli_connect_error() . "\n";
} else {
    $sql = "CREATE DATABASE IF NOT EXISTS $dbName";
    if (!mysqli_query($link, $sql)) {
        $error .= "Не удалось создать БД: " . mysqli_error($link) . "\n";
    }

    mysqli_close($link);

    $link = mysqli_connect($servername, $username, $password, $dbName);

    if (!$link) {
        $error .= "Ошибка подключения: " . mysqli_connect_error() . "\n";
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(15) NOT NULL,
            email VARCHAR(50) NOT NULL,
            pass VARCHAR(20) NOT NULL
        )";
        if (!mysqli_query($link, $sql)) {
            $error .= "Не удалось создать таблицу users: " . mysqli_error($link) . "\n";
        }

        $sql = "CREATE TABLE IF NOT EXISTS user_posts (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(100) NOT NULL,
            content VARCHAR(400) NOT NULL
        )";
        if (!mysqli_query($link, $sql)) {
            $error .= "Не удалось создать таблицу user_posts: " . mysqli_error($link) . "\n";
        }

        mysqli_close($link);
    }
}

if ($error) {
    echo nl2br($error);
}
?>
