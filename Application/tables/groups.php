<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    header("Location: groupsUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM groups WHERE Group_id = ' . $_POST["delete"] . '';
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

if (isset($_POST['Insert'])) {
    $Gr_name = $_POST['Gr_name'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "INSERT INTO groups(Gr_name, Comments) VALUES ('$Gr_name', '$Comments')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

if (isset($_POST["Return"])) {
    header("Location: ../Database.php");
}

echo "
<form action='groups.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Groups</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='groups.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Name </th>
                        <th scope='col'> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Gr_name' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Comments' id = 'Comments'>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Group</button>
        </form>
    </div>
</div>";
?>
<form action="groups.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Group id</option>
                <option>Name</option>
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
            <th scope='col'> Group id </th>
            <th scope='col'> Name </th>
            <th scope='col'> Comment </th>
            <?php
            if ($_SESSION["grade"] == "admin") echo
                "<th scope='col'> Change </th>
                <th scope='col'> Delete </th>";
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($_POST['Order'])){
            $col = $_POST['col'];
            $order = $_POST['orderby'];

            if($col == "Group id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM groups order by Group_id asc');
            else if($col == "Group id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM groups order by Group_id desc');
            else if($col == "Name" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM groups order by Gr_name asc');
            else if($col == "Name" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM groups order by Gr_name desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM groups');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Group_id']}</td>
            <td>{$result['Gr_name']}</td>
            <td>{$result['Comments']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'groupsUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Group_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'groups.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Group_id']} name = 'delete'>Delete</button>
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