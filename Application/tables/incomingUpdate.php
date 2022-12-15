<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/incoming.php");
}

if(isset($_POST["Update"])){
    $Inc_id = $_POST['Inc_id'];
    $Prod_id = $_POST['Prod_id'];
    $Tax_id = $_POST['Tax_id'];
    $Contr_id = $_POST['Contr_id'];
    $Man_id = $_POST['Man_id'];
    $Inc_date = $_POST['Inc_date'];
    $Quantity = $_POST['Quantity'];
    $Cost = $_POST['Cost'];


    $sql = "UPDATE incoming set Prod_id = $Prod_id, Tax_id = $Tax_id, Contr_id = $Contr_id, 
            Man_id = $Man_id, Inc_date = '$Inc_date', Quantity = $Quantity, Cost = $Cost where Inc_id = $Inc_id";

    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/incoming.php'</script>";
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: incoming.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from incoming where Inc_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>

<form action='incomingUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="incomingUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope='col'> Incoming Id </th>
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
                                <?php echo "<input type='text' class='form-control' name='Inc_id' pattern = '[0-9]{,5}' value = '{$_POST['change']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Prod_id' pattern = '[0-9]{,5}' value = '{$result['Prod_id']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Tax_id' pattern = '[0-9]{,5}' value = '{$result['Tax_id']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Contr_id' pattern = '[0-9]{,5}' value = '{$result['Contr_id']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Man_id' id = 'Man_id' pattern = '[0-9]{,5}' value = '{$result['Man_id']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Inc_date' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}' value = '{$result['Inc_date']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Quantity' id = 'Quantity' pattern = '[0-9]{,7}' value = '{$result['Quantity']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Cost' id = 'Cost' pattern = '[0-9]{,7}\.[0-9]{,2}' value = '{$result['Cost']}'>";?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-outline-primary" name = 'Update'>Update</button>
        </form>
    </div>
</div>
<?php
include('../parts/footer.php');
?>