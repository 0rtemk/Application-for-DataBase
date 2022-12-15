<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/prices.php");
}

if(isset($_POST["Update"])){
    $Prod_id = $_POST['Prod_id'];
    $DayFrom = $_POST['DayFrom'];
    $DateTo = $_POST['DateTo'];
    $P_value = $_POST['P_value'];

    $sql = "UPDATE prices set DateTo = '$DateTo', P_value = $P_value where prod_id = $Prod_id and DayFrom = '$DayFrom'";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/prices.php'</script>";
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: prices.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from prices where prod_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>

<form action='pricesUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="pricesUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Product id </th>
                        <th scope="col"> Day from </th>
                        <th scope="col"> Date to </th>
                        <th scope="col"> Price value </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' readonly name='Prod_id' value = {$_POST["change"]}></input>"?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' readonly name='DayFrom' value = '{$result['DayFrom']}' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}'>";?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' name='DateTo' value = '{$result['DateTo']}' pattern = '[0-9]{4}-[0-9]{2}-[0-9]{2}'>";?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' name='P_value' value = '{$result['P_value']}' pattern = '[0-9]{,7}\.[0-9]{,2}'>";?>
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