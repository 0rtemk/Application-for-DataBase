<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/taxes.php");
}

if(isset($_POST["Update"])){
    $Tax_id = $_POST['Tax_id'];
    $Tax_name = $_POST['Tax_name'];
    $Tax_value = $_POST['Tax_value'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "UPDATE taxes set Tax_name = '$Tax_name', Tax_value = $Tax_value, Comments = '$Comments' where Tax_id = $Tax_id";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/taxes.php'</script>";
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: taxes.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from taxes where Tax_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>

<form action='taxesUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="taxesUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Tax id </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Value </th>
                        <th scope="col"> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' readonly name='Tax_id' value = {$_POST["change"]}></input>"?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' name='Tax_name' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' value = '{$result['Tax_name']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Tax_value' pattern = '[0-9]{,1}\.[0-9]{,4}' value = '{$result['Tax_value']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' name='Comments' value = '{$result['Comments']}'>";?>
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