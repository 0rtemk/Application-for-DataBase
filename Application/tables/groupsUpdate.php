<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/groups.php");
}

if(isset($_POST["Update"])){
    $Group_id = $_POST['Group_id'];
    $Gr_name = $_POST['Gr_name'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "UPDATE groups set Gr_name = '$Gr_name', Comments = '$Comments' where Group_id = $Group_id";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/groups.php'</script>";
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: groups.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from groups where group_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>
<form action='groupsUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="groupsUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Name </th>
                        <th scope="col"> Comment </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' readonly name='Group_id' value = {$_POST["change"]}></input>"?>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <?php echo "<input type='text' class='form-control' name='Gr_name' value = '{$result['Gr_name']}' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' required>";?>
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