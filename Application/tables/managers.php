<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    header("Location: managersUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM Managers WHERE Man_id = ' . $_POST["delete"] . '';
    try {
        $bd_connect->query($sql);
    } catch (Exception $e) {
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }
    header("Refresh:0");
}

if (isset($_POST["Return"])) {
    header("Location: ../Database.php");
}

if (isset($_POST['Insert'])) {
    $Man_name = $_POST['Man_name'];
    $Persent = $_POST['Persent'];
    $Hire_day = $_POST['Hire_day'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "";
    if ($_POST['Parent_id'] != "") {
        $Parent_id = $_POST['Parent_id'];
        $sql = "INSERT INTO Managers(Man_name, Persent, Hire_day, Comments, Parent_id) VALUES ('$Man_name', '$Persent', '$Hire_day', '$Comments', '$Parent_id')";
    } else {
        $sql = "INSERT INTO Managers(Man_name, Persent, Hire_day, Comments, Parent_id) VALUES ('$Man_name', '$Persent', '$Hire_day', '$Comments', NULL)";
    }

    try {
        $bd_connect->query($sql);
    } catch (Exception $e) {
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }
    header("Refresh:0");
}

echo "
<form action='managers.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Managers</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='managers.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Name </th>
                        <th scope='col'> Percent </th>
                        <th scope='col'> Hire day </th>
                        <th scope='col'> Comment </th>
                        <th scope='col'> Parent id </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Man_name' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Persent' pattern = '[0-9]{,1}\.[0-9]{,4}' placeholder = '0.0010' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Hire_day' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' placeholder = 'YYYY-MM-DD' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Comments'>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Parent_id' pattern = '[0-9]{,5}' placeholder = '1'>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Manager</button>
        </form>
    </div>
</div>";
?>
<form action="managers.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name='col'>
                <option>Manager id</option>
                <option>Name</option>
                <option>Percent</option>
                <option>Hire day</option>
            </select>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name='orderby'>
                <option>ascending</option>
                <option>descending</option>
            </select>
        </div>
        <div class="col-auto text-center">
            <button class='btn btn-sm btn-outline-primary' type='submit' name='Order'>apply</button>
        </div>
    </div>
</form>

<div class='px-5'>
    <table class='table table-bordered'>
        <thead>
            <tr class='text-center'>
                <th scope='col'> Manager id </th>
                <th scope='col'> Name </th>
                <th scope='col'> Percent </th>
                <th scope='col'> Hire day </th>
                <th scope='col'> Comment </th>
                <th scope='col'> Parent id </th>
                <?php
                if ($_SESSION["grade"] == "admin") echo
                "<th scope='col'> Change </th>
                <th scope='col'> Delete </th>";
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_POST['Order'])) {
                $col = $_POST['col'];
                $order = $_POST['orderby'];

                if ($col == "Manager id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Man_id asc');
                else if ($col == "Manager id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Man_id desc');
                else if ($col == "Name" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Man_name asc');
                else if ($col == "Name" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Man_name desc');
                else if ($col == "Percent" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Persent asc');
                else if ($col == "Percent" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Persent desc');
                else if ($col == "Hire day" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Hire_day asc');
                else if ($col == "Hire day" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM managers order by Hire_day desc');
            } else $sql = mysqli_query($bd_connect, 'SELECT * FROM managers');

            while ($result = mysqli_fetch_array($sql)) {
                echo
                "<tr><td>{$result['Man_id']}</td>
            <td>{$result['Man_name']}</td>
            <td>{$result['Persent']}</td>
            <td>{$result['Hire_day']}</td>
            <td>{$result['Comments']}</td>
            <td>{$result['Parent_id']}</td>";
                if ($_SESSION["grade"] == "admin") echo
                "<td class = 'text-center'>
                <form action = 'managersUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Man_id']} name = 'change'>Change</button>
                </form>
            </td>";
                if ($_SESSION["grade"] == "admin") echo
                "<td class = 'text-center'>
                <form action = 'managers.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Man_id']} name = 'delete'>Delete</button>
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