<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    header("Location: pricesUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM prices WHERE Prod_id = ' . $_POST["delete"] . '';
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
    $DayFrom = $_POST['DayFrom'];
    $DateTo = $_POST['DateTo'];
    $P_value = $_POST['P_value'];

    $sql = "INSERT INTO prices(Prod_id, DayFrom, DateTo, P_value) VALUES ('$Prod_id', '$DayFrom', '$DateTo', '$P_value')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo"
<form action='prices.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Prices</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='prices.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Product id </th>
                        <th scope='col'> Day from </th>
                        <th scope='col'> Date to </th>
                        <th scope='col'> Price value </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Prod_id' pattern = '[0-9]{,4}' placeholder = '1' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='DayFrom' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' placeholder = 'YYYY-MM-DD' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='DateTo' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' placeholder = 'YYYY-MM-DD'>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='P_value' pattern = '[0-9]{,7}\.[0-9]{,2}' placeholder = '0000.00' required>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Price</button>
        </form>
    </div>
</div>";
?>
<form action="prices.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Product id</option>
                <option>Day from</option>
                <option>Date to</option>
                <option>Price value</option>
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
            <th scope='col'> Product id </th>
            <th scope='col'> Day from </th>
            <th scope='col'> Date to </th>
            <th scope='col'> Price value </th>
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

            if($col == "Product id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by Prod_id asc');
            else if($col == "Product id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by Prod_id desc');
            else if($col == "Day from" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by DayFrom asc');
            else if($col == "Day from" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by DayFrom desc');
            else if($col == "Date to" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by DateTo asc');
            else if($col == "Date to" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by DateTo desc');
            else if($col == "Price value" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by P_value asc');
            else if($col == "Price value" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM prices order by P_value desc');
            
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM prices');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Prod_id']}</td>
            <td>{$result['DayFrom']}</td>
            <td>{$result['DateTo']}</td>
            <td>{$result['P_value']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'pricesUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Prod_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'prices.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-danger' type='submit' value = {$result['Prod_id']} name = 'delete'>Delete</button>
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