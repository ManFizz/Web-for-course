<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перепечин В.В.</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-12 index">
				<h1>Страница постов!</h1>
				<?php
				if (!isset($_COOKIE['User'])) {
					echo '<a href="/reg.php">Зарегестрируйтесь</a> или <a href="/login.php">войдите</a>';
				} else {
					include 'db.php';

					$link = mysqli_connect($servername, $username, $password, $dbName);
					if (!$link) {
						echo "Ошибка подключения: " . mysqli_connect_error();
						exit();
					}

					$sql = "SELECT * FROM user_posts";
					$res = mysqli_query($link, $sql);

					if ($res && mysqli_num_rows($res) > 0) {
						while ($post = mysqli_fetch_array($res)) {
							echo "<a href='/posts.php?id=" . htmlspecialchars($post["id"]) . "'>" . htmlspecialchars($post['title']) . "</a><br>";
						}
					} else {
						echo "Записей пока нет";
					}
					mysqli_close($link);
				}?>
			</div>
		</div>
	</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
