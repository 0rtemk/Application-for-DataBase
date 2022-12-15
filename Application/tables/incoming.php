<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {

    header("Location: incomingUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM incoming WHERE Inc_id = ' . $_POST["delete"] . '';
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
    $Inc_date = $_POST['Inc_date'];
    $Quantity = $_POST['Quantity'];
    $Cost = $_POST['Cost'];
    
    $sql = "INSERT INTO incoming(Prod_id, Tax_id, Contr_id, Man_id, Inc_date, Quantity, Cost) 
        VALUES ('$Prod_id', '$Tax_id', '$Contr_id', '$Man_id', '$Inc_date', '$Quantity', '$Cost')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo"
<form action='incoming.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";


if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Incoming</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='incoming.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Product id </th>
                        <th scope='col'> Tax id </th>
                        <th scope='col'> Contragent id </th>
                        <th scope='col'> Manager id </th>
                        <th scope='col'> Incoming date </th>
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
                                <input type='text' class='form-control' name='Inc_date' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' placeholder = 'YYYY-MM-DD' required>
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
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Incoming</button>
        </form>
    </div>
</div>";
?>
<form action="incoming.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Incoming id</option>
                <option>Product id</option>
                <option>Tax id</option>
                <option>Contragent id</option>
                <option>Manager id</option>
                <option>Incoming date</option>
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
            <th scope='col'> Incoming id </th>
            <th scope='col'> Product id </th>
            <th scope='col'> Tax id </th>
            <th scope='col'> Contragent id </th>
            <th scope='col'> Manager id </th>
            <th scope='col'> Incoming date </th>
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

            if($col == "Incoming id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Inc_id asc');
            else if($col == "Incoming id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Inc_id desc');
            else if($col == "Product id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Prod_id asc');
            else if($col == "Product id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Prod_id desc');
            else if($col == "Tax id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Tax_id asc');
            else if($col == "Tax id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Tax_id desc');
            else if($col == "Contragent id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Contr_id asc');
            else if($col == "Contragent id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Contr_id desc');
            else if($col == "Manager id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Man_id asc');
            else if($col == "Manager id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Man_id desc');
            else if($col == "Incoming date" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Inc_date asc');
            else if($col == "Incoming date" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Inc_date desc');
            else if($col == "Quantity" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Quantity asc');
            else if($col == "Quantity" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Quantity desc');
            else if($col == "Cost" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Cost asc');
            else if($col == "Cost" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming order by Cost desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM incoming');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Inc_id']}</td>
            <td>{$result['Prod_id']}</td>
            <td>{$result['Tax_id']}</td>
            <td>{$result['Contr_id']}</td>
            <td>{$result['Man_id']}</td>
            <td>{$result['Inc_date']}</td>
            <td>{$result['Quantity']}</td>
            <td>{$result['Cost']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'incomingUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Inc_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'incoming.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Inc_id']} name = 'delete'>Delete</button>
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