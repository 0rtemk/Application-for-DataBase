<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    header("Location: contragentsUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM Contragents WHERE Contr_id = ' . $_POST["delete"] . '';
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

if (isset($_POST['Insert'])) {
    $Contr_name = $_POST['Contr_name'];
    $Adress = $_POST['Adress'];
    $Phone = $_POST['Phone'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "INSERT INTO Contragents(Contr_name, Adress, Phone, Comments) VALUES ('$Contr_name', '$Adress', '$Phone', '$Comments')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo "
<form action='contragents.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Contragents</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='Contragents.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Name </th>
                        <th scope='col'> Adress </th>
                        <th scope='col'> Phone </th>
                        <th scope='col'> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Contr_name' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Adress' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Phone' pattern = '[0-9+]{,15}' required>
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
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Contragent</button>
        </form>
    </div>
</div>";
?>
<form action="contragents.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Contragent id</option>
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
            <th scope='col'> Contragent id </th>
            <th scope='col'> Name </th>
            <th scope='col'> Adress </th>
            <th scope='col'> Phone </th>
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

            if($col == "Contragent id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Contragents order by Contr_id asc');
            else if($col == "Contragent id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Contragents order by Contr_id desc');
            else if($col == "Name" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Contragents order by Contr_name asc');
            else if($col == "Name" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Contragents order by Contr_name desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM Contragents');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Contr_id']}</td>
            <td>{$result['Contr_name']}</td>
            <td>{$result['Adress']}</td>
            <td>{$result['Phone']}</td>
            <td>{$result['Comments']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'ContragentsUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Contr_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'Contragents.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Contr_id']} name = 'delete'>Delete</button>
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