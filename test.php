<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тест SQL инъекций</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-dark text-white">

<?php
include 'db.php';

// Включаем отображение всех ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

$link = mysqli_connect($servername, $username, $password, $dbName);

if (!$link) {
    echo '<div class="alert alert-danger" role="alert">Ошибка подключения к базе данных: ' . mysqli_connect_error() . '</div>';
}

// Получаем ID из GET запроса без валидации и очистки
$id = $_GET['id'] ?? ''; // Используем null coalescing operator для избежания ошибок undefined index

$sql = "SELECT * FROM user_posts WHERE id=$id"; // Намеренно уязвимый запрос
echo $sql;

$res = mysqli_query($link, $sql);

if (!$res) {
    echo '<div class="alert alert-danger" role="alert">Ошибка SQL запроса: ' . mysqli_error($link) . '</div>';
} else {
    if ($rows = mysqli_fetch_array($res)) {
        $title = $rows['title'];
        $content = $rows['content'];
        echo "<h1>$title</h1>";
        echo "<p>$content</p>";
    } else {
        echo '<div class="alert alert-warning" role="alert">Пост не найден.</div>';
    }
}

mysqli_close($link);
?>

</body>
</html>
