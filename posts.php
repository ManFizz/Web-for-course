<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Не передан ID поста.";
    exit();
}

$post_id = intval($_GET['id']);

$link = mysqli_connect($servername, $username, $password, $dbName);
if (!$link) {
    echo "Ошибка подключения: " . mysqli_connect_error();
    exit();
}

$sql = "SELECT id, title, content FROM user_posts WHERE id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$post = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр поста</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-dark text-white">
<div class="container mt-5">
    <?php if ($post): ?>
        <div class="card bg-secondary text-white">
            <div class="card-header">
                <h1><?= htmlspecialchars($post['title']) ?></h1>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Пост с таким ID не найден.
        </div>
    <?php endif; ?>
</div>
</body>
</html>
