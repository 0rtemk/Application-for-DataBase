<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}
else if($_SESSION["grade"] != "admin"){
    header("Location: http://localhost/Application/tables/managers.php");
}

if(isset($_POST["Update"])){
    $Man_id = $_POST['UpdateMan_id'];
    $Man_name = $_POST['Man_name'];
    $Persent = $_POST['Persent'];
    $Hire_day = $_POST['Hire_day'];
    if (isset($_POST['Comments'])) $Comments = $_POST['Comments'];
    else $Comments = NULL;

    $sql = "";
    if ($_POST['Parent_id'] != "") {
        $Parent_id = $_POST['Parent_id'];
        $sql = "UPDATE MANAGERS set Man_name = '$Man_name', Persent = $Persent, Hire_day = '$Hire_day', 
            Comments = '$Comments', Parent_id = $Parent_id where Man_id = $Man_id";
    } else {
        $sql = "UPDATE MANAGERS set Man_name = '$Man_name', Persent = $Persent, Hire_day = '$Hire_day', 
        Comments = '$Comments', Parent_id = NULL where Man_id = $Man_id";
    }

    try {
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    echo "<script>document.location.href = 'http://localhost/Application/tables/managers.php'</script>";
    
}

if (isset($_POST["ReturnUpdate"])) {
    header("Location: managers.php");
}

$sql = mysqli_query($bd_connect,'SELECT * from managers where Man_id = '.$_POST["change"].'');
$result = mysqli_fetch_array($sql);
?>

<form action='managersUpdate.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'ReturnUpdate'><<< back</button>
        </div>
    </div>
</form>

<h2 class="text-center p-1">Update data</h2>

<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <form action="managersUpdate.php" method="post">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col"> Manager id </th>
                        <th scope="col"> Name </th>
                        <th scope="col"> Percent </th>
                        <th scope="col"> Hire day </th>
                        <th scope="col"> Comment </th>
                        <th scope="col"> Parent id </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' readonly name='UpdateMan_id' value = {$_POST["change"]}></input>"?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Man_name' value = '{$result['Man_name']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Persent' value = '{$result['Persent']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Hire_day' value = '{$result['Hire_day']}' required>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Comments' value = '{$result['Comments']}'>";?>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <?php echo "<input type='text' class='form-control' name='Parent_id' value = '{$result['Parent_id']}'>";?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-outline-primary" name = "Update" >Update</button>
        </form>
    </div>
</div>
<?php
include('../parts/footer.php');
?>