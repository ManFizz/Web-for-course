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
    $username = mysqli_real_escape_string($link, $_POST['login']);
    $password = mysqli_real_escape_string($link, $_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Пожалуйста, введите все значения!";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['pass']) {
                setcookie("User", $username, time() + 7200);
                header('Location: profile.php');
                exit();
            } else {
                $error = "Неправильное имя или пароль";
            }
        } else {
            $error = "Неправильное имя или пароль";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Вход</h1>
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
                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <input class="form-control" type="text" name="login" placeholder="Login" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-danger" name="submit">Продолжить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
