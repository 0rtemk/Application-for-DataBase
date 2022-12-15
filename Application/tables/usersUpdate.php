<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/Database.php");
}

if(isset($_POST["Update"])){
    $user_id = $_POST['Updateuser_id'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $grade = $_POST['grade'];

    $sql = "UPDATE users set email = '$email', login = '$login', password = '$password', grade = '$grade' where user_id = $user_id";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }
    echo "<script>document.location.href = 'http://localhost/Application/tables/users.php'</script>";
}

if (isset($_POST["ReturnUpdate"]) || $_SESSION['ID'] == $_POST["change"]) {
    header("Location: users.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from users where user_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>
<form action='usersUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="usersUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Email </th>
                        <th scope="col"> Login </th>
                        <th scope="col"> Password </th>
                        <th scope="col"> Grade </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='email' value = '{$result['email']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='login' value = '{$result['login']}' pattern = '^[A-Za-z0-9]+$' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='password' value = '{$result['password']}' pattern = '^[A-Za-z0-9_]+$' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <select class='form-control form-control-sm' name = 'grade'>
                                    <option>viewer</option>
                                    <option>admin</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-outline-primary" name="Update">Update</button>
        </form>
    </div>
</div>
<?php
include('../parts/footer.php');
?>