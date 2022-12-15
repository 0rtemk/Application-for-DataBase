<?php
include('parts/bd_connect.php');
include('parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}
?>
<h1 class='text-center py-2'>Welcome Page</h1>
<div class='px-5'>
    <p class="text-justify pb-1">Добро пожаловать в приложение для мониторинга базы данных</p>
    <p class="text-justify pb-1">Перед использованием приложения, рекомендуется ознакомиться с технической справкой, представленной ниже</p>
</div>
<?php
include('parts/footer.php');
?>