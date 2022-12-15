<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    if($_SESSION['ID'] == $_POST["change"]){
        echo "<script>alert('You can not change User with active session')</script>";
    }
    else header("Location: usersUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    if($_SESSION['ID'] == $_POST["delete"]){
        echo "<script>alert('You can not delete User with active session')</script>";
    }
    else {
        $sql = 'DELETE FROM users WHERE user_id = ' . $_POST["delete"] . '';
        try{
            $bd_connect->query($sql);
        } catch (Exception $e){
            echo "<script>alert(\"{$e->getMessage()}\")</script>";
        }
        header("Refresh:0");
    }
}

if (isset($_POST["Return"]) || $_SESSION["grade"] != "admin") {
    header("Location: ../Database.php");
}

if (isset($_POST['addUser'])) {
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO users(email, login, password, grade) VALUES ('$email', '$login', '$password', '$grade')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo "
<form action='users.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>

<h2 class='text-center p-1'>Users</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='users.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Email </th>
                        <th scope='col'> Login </th>
                        <th scope='col'> Password </th>
                        <th scope='col'> Grade </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>  
                        <td>
                            <div class='text-center'>
                                <input type='email' class='form-control' name='email' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='login' pattern = '^[A-Za-z0-9]+$' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='password' pattern = '^[A-Za-z0-9_]+$' required>
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
            <button type='submit' class='btn btn-outline-primary' name = 'addUser'>Add User</button>
        </form>
    </div>
</div>";
?>
<form action="users.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>User id</option>
                <option>Grade</option>
            </select>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'orderby'>
                <option>ascending</option>
                <option>descending</option>
            </select>
        </div>
        <div class="col-auto text-center">
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Order'>apply</button>
        </div>
    </div>
</form>

<div class = 'px-5'>
<table class='table table-bordered'>
    <thead>
        <tr class = 'text-center'>
            <th scope='col'> User id </th>
            <th scope='col'> Email </th>
            <th scope='col'> Login </th>
            <th scope='col'> Password </th>
            <th scope='col'> Grade </th>
            <th scope='col'> Change </th>
            <th scope='col'> Delete </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($_POST['Order'])){
            $col = $_POST['col'];
            $order = $_POST['orderby'];

            if($col == "User id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM users order by user_id asc');
            else if($col == "User id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM users order by user_id desc');
            else if($col == "Grade" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM users order by grade asc');
            else if($col == "Grade" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM users order by grade desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM users');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['user_id']}</td>
            <td>{$result['email']}</td>
            <td>{$result['login']}</td>
            <td>{$result['password']}</td>
            <td>{$result['grade']}</td>
            <td class = 'text-center'>
                <form action = 'usersUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['user_id']} name = 'change'>Change</button>
                </form>
            </td>
            <td class = 'text-center'>
                <form action = 'users.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['user_id']} name = 'delete'>Delete</button>
                </form>
            </td></tr>";
        }
        ?>
    </tbody>
</table>
</div>
<?php
include('../parts/footer.php');
?>