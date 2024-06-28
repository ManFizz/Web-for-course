<?php
include 'db.php';

$error = "";
$posts = [];

$link = mysqli_connect($servername, $username, $password, $dbName);
if (!$link) {
    $error .= "Ошибка подключения к базе данных: " . mysqli_connect_error() . "\n";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!empty($_FILES["file"]))
		{
			if (((@$_FILES["file"]["type"] == "image/gif") || (@$_FILES["file"]["type"] == "image/jpeg")
			|| (@$_FILES["file"]["type"] == "image/jpg") || (@$_FILES["file"]["type"] == "image/pjpeg")
			|| (@$_FILES["file"]["type"] == "image/x-png") || (@$_FILES["file"]["type"] == "image/png"))
			&& (@$_FILES["file"]["size"] < 102400))
			{
				move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
				echo "Load in:  " . "upload/" . $_FILES["file"]["name"];
			}
			else
			{
				echo "upload failed!";
			}
		}

        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO user_posts (title, content) VALUES (?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $title, $content);

        if (!mysqli_stmt_execute($stmt)) {
            $error .= "Ошибка при добавлении записи: " . mysqli_error($link) . "\n";
        }
        mysqli_stmt_close($stmt);
    }

    $sql = "SELECT * FROM user_posts ORDER BY id DESC";
    $result = mysqli_query($link, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    } else {
        $error .= "Ошибка при загрузке записей: " . mysqli_error($link) . "\n";
    }

    mysqli_close($link);
}

if ($error) {
    echo nl2br($error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перепечин В.В.</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">

    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<header class="navbar navbar-expand-lg sticky-top navbar-dark text-white bg-dark">
    <div class="container-fluid">
        <div class="row flex-row flex-warp w-100">
            <div class="col-1 logo ms-5"></div>
            <div class="col-8">
                <div class="navbar-nav flex-row flex-wrap bd-navbar-nav">
                    <div class="btn-group m-auto">
						<a class="btn btn-outline-light" htmlFor="btnradio-1" href="news.php">Новости</a>
                    </div>
                </div>
            </div>

            <div class="col-3 text-block"><h2>Сайт by ManFis?!</h2></div>
        </div>
    </div>
</header>
<div class="container">
    <h2>Добавить новую статью</h2>
	<form method="POST" enctype="multipart/form-data" name="upload">
		<div class="form-group">
			<label for="title">Заголовок статьи:</label>
			<input type="text" class="form-control" id="title" name="title" required>
		</div>
		<div class="form-group">
			<label for="content">Содержание статьи:</label>
			<textarea class="form-control" id="content" name="content" required rows="4"></textarea>
		</div>
		<div class="form-group">
			<label for="content">Файлы:</label>
			<input type="file" name="file" /><br>
		</div>
		<button type="submit" class="btn btn-primary">Добавить</button>
	</form>

    <h2>Список статей</h2>
    <?php if (count($posts) > 0): ?>
        <ul class="list-group">
            <?php foreach ($posts as $post): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($post['title']) ?></strong>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет опубликованных статей.</p>
    <?php endif; ?>
</div>
</body>
</html>