<?php
    include('parts/bd_connect.php');
    include('parts/header.php');
    include('parts/login.html');
    
    if(!empty($_SESSION["login"]))
    {
        header("Location: WelcomePage.php");
    }

    if(isset($_POST['login']) && isset($_POST['password']))
    {
        $sql = "SELECT * FROM users WHERE login = '".$_POST['login']."' AND password = '".$_POST['password']."'";
        $res = mysqli_query($bd_connect, $sql);
        $user = mysqli_fetch_assoc($res);
        if(!isset($user))
        {
            echo "<script>console.log('User not found')</script>";
            //header("Location: reg.php");
        }
        else
        {
            $_SESSION['grade'] = $user['grade'];
            $_SESSION["ID"] = $user['user_id'];
            $_SESSION["login"] = $_POST['login'];
            $_SESSION["password"] = $_POST['password'];
            header("Location: WelcomePage.php");
        }
    }

    include('parts/footer.php');
?>
