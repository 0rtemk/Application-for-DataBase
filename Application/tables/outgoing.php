<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {

    header("Location: outgoingUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM Outgoing WHERE Out_id = ' . $_POST["delete"] . '';
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
    $Prod_id = $_POST['Prod_id'];
    $Tax_id = $_POST['Tax_id'];
    $Contr_id = $_POST['Contr_id'];
    $Man_id = $_POST['Man_id'];
    $Out_date = $_POST['Out_date'];
    $Quantity = $_POST['Quantity'];
    $Cost = $_POST['Cost'];
    
    $sql = "INSERT INTO Outgoing(Prod_id, Tax_id, Contr_id, Man_id, Out_date, Quantity, Cost) 
        VALUES ('$Prod_id', '$Tax_id', '$Contr_id', '$Man_id', '$Out_date', '$Quantity', '$Cost')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo"
<form action='outgoing.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Outgoing</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='Outgoing.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Product id </th>
                        <th scope='col'> Tax id </th>
                        <th scope='col'> Contragent id </th>
                        <th scope='col'> Manager id </th>
                        <th scope='col'> Outgoing date </th>
                        <th scope='col'> Quantity </th>
                        <th scope='col'> Cost </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Prod_id' pattern = '[0-9]{,5}' placeholder = '0' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Tax_id' pattern = '[0-9]{,5}' placeholder = '0' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Contr_id' pattern = '[0-9]{,5}' placeholder = '0' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Man_id' id = 'Man_id' pattern = '[0-9]{,5}' placeholder = '0' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Out_date' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' placeholder = 'YYYY-MM-DD' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Quantity' id = 'Quantity' pattern = '[0-9]{,7}' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Cost' id = 'Cost' pattern = '[0-9]{,7}\.[0-9]{,2}' required>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Outgoing</button>
        </form>
    </div>
</div>";
?>
<form action="Outgoing.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Outgoing id</option>
                <option>Product id</option>
                <option>Tax id</option>
                <option>Contragent id</option>
                <option>Manager id</option>
                <option>Outgoing date</option>
                <option>Quantity</option>
                <option>Cost</option>
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
            <th scope='col'> Outgoing id </th>
            <th scope='col'> Product id </th>
            <th scope='col'> Tax id </th>
            <th scope='col'> Contragent id </th>
            <th scope='col'> Manager id </th>
            <th scope='col'> Outgoing date </th>
            <th scope='col'> Quantity </th>
            <th scope='col'> Cost </th>
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

            if($col == "Outgoing id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Out_id asc');
            else if($col == "Outgoing id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Out_id desc');
            else if($col == "Product id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Prod_id asc');
            else if($col == "Product id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Prod_id desc');
            else if($col == "Tax id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Tax_id asc');
            else if($col == "Tax id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Tax_id desc');
            else if($col == "Contragent id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Contr_id asc');
            else if($col == "Contragent id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Contr_id desc');
            else if($col == "Manager id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Man_id asc');
            else if($col == "Manager id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Man_id desc');
            else if($col == "Outgoing date" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Out_date asc');
            else if($col == "Outgoing date" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Out_date desc');
            else if($col == "Quantity" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Quantity asc');
            else if($col == "Quantity" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Quantity desc');
            else if($col == "Cost" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Cost asc');
            else if($col == "Cost" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing order by Cost desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM Outgoing');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Out_id']}</td>
            <td>{$result['Prod_id']}</td>
            <td>{$result['Tax_id']}</td>
            <td>{$result['Contr_id']}</td>
            <td>{$result['Man_id']}</td>
            <td>{$result['Out_date']}</td>
            <td>{$result['Quantity']}</td>
            <td>{$result['Cost']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'OutgoingUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Out_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'Outgoing.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Out_id']} name = 'delete'>Delete</button>
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