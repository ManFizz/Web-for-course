<?php
if (isset($_COOKIE['User'])) {
    header("Location: profile.php");
}


require_once('db.php');

$error = "";
$success = "";

$link = mysqli_connect($servername, $username, $password, $dbName);

if (!$link) {
    $error = "Ошибка подключения: " . mysqli_connect_error();
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $username = mysqli_real_escape_string($link, $_POST['login']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    if (!$email || !$username || !$password) {
        $error = "Пожалуйста, введите все значения!";
    } else {
        $sql = "INSERT INTO users (email, username, pass) VALUES ('$email', '$username', '$password')";
        if (!mysqli_query($link, $sql)) {
            $error = "Не удалось добавить пользователя: " . mysqli_error($link);
        } else {
            $success = "Пользователь успешно добавлен!";
			header("Location: login.php");
        }
    }
}

mysqli_close($link);
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
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>Регистрация</h1>
			</div>
		</div>
		
		<div class="row">
			<div class="col-12">
			
                <?php
                if ($error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                } elseif ($success) {
                    echo "<div class='alert alert-success'>$success</div>";
                }
                ?>
				<form method="POST" action="reg.php">
					<div class="row form__reg"><input class="form" type="email" name="email" placeholder="Email"></div>
					<div class="row form__reg"><input class="form" type="text" name="login" placeholder="Login"></div>
					<div class="row form__reg"><input class="form" type="password" name="password" placeholder="Password"></div>
					<button type="submit" class="btn-red btn__reg" name="submit">Продолжить</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>