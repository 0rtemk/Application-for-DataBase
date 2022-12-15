<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/products.php");
}

if(isset($_POST["Update"])){
    $Prod_id= $_POST['Prod_id'];
    $Group_id= $_POST['Group_id'];
    $Prod_name= $_POST['Prod_name'];
    $Expire_time = $_POST['Expire_time'];
    if (isset($_POST['Descriptions'])) $Descriptions = $_POST['Descriptions'];
    else $Descriptions = NULL;

    $sql = "UPDATE products set Prod_name= '$Prod_name', Group_id = '$Group_id', Expire_time = $Expire_time, Descriptions = '$Descriptions' where Prod_id= $Prod_id";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/products.php'</script>";
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: products.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from products where Prod_id= '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>

<form action='productsUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="productsUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Product id </th>
                        <th scope="col"> Group id </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Description </th>
                        <th scope="col"> Expire_time </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' readonly name='Prod_id' value = {$_POST["change"]}></input>"?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Group_id' value = '{$result['Group_id']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Prod_name' value = '{$result['Prod_name']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Descriptions' value = '{$result['Descriptions']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Expire_time' value = '{$result['Expire_time']}' required>";?>
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