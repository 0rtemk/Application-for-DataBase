<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LogReg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>

<body class="px-2">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="./login.php" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img class="bi me-2" width="30" height="30" src="https://avatars.mds.yandex.net/i?id=51c7ca5cb0d70b2e3baef397368bc2f3_sr-6609300-images-thumbs&n=13&exp=1">
        </a>
        <?php
        session_start();

        if (!empty($_SESSION["login"])) {
            echo "<ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>";
            echo "<li><a href='http://localhost/Application/WelcomePage.php' class='nav-link px-2 link-secondary'>Home</a></li>";
            echo "<li><a href='http://localhost/Application/Database.php' class='nav-link px-2 link-dark'>Database</a></li>";
            echo "<li><a href='http://localhost/Application/Console.php' class='nav-link px-2 link-dark'>Console</a></li>";
            echo "</ul>";

            echo "<div class='col-md-3 text-end'>";

            echo "<a type='button' class='btn btn-outline-primary me-2' href='?exit'>Exit</a>";

            echo "</div>";

            if (isset($_REQUEST["exit"])) {
                session_destroy();
                header("Location: http://localhost/Application/login.php");
            }
        } else {
            echo "<div class='col-md-3 text-end'>";
            echo "<a type='button' class='btn btn-outline-primary me-2' href='?login'>Login</a>";
            echo "</div>";

            if (isset($_REQUEST["login"])) {
                header("Location: http://localhost/Application/login.php");
            }
        }
        ?>
    </header>