<?php
include('parts/bd_connect.php');
include('parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}
?>
<h1 class = 'text-center py-2'>Console</h1>
<div class = 'px-5'>
<form action="Console.php" method="post" class = 'pb-3'>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Write a request in the text window</label>
        <?php 
            if(isset($_POST['perform'])) echo "<textarea class='form-control' id='exampleFormControlTextarea1' name = 'perform' rows='3'>{$_POST['perform']}</textarea>";
            else echo "<textarea class='form-control' id='exampleFormControlTextarea1' name = 'perform' rows='3'></textarea>";
        ?>
    </div>
    <div class = 'text-center'>
        <button type="submit" class="btn btn-primary" name = "request">Perform</button>
    </div>
</form>
<?php
if(isset($_POST['request'])){
    $parseArray = explode(' ', $_POST['perform']);
    switch(mb_strtolower($parseArray[0])) {
        case "insert":
        case "update":
        case "delete":
            if ($_SESSION["grade"] != "admin") {
                echo "<div class = 'text-danger'>You have no permissions to use this request</div>";
            }
            else {
                try {
                    $bd_connect->query($_POST['perform']);
                    echo "<div class = 'text-success'>request completed</div>";   
                    
                } catch (Exception $e){
                    echo "<script>alert(\"{$e->getMessage()}\")</script>";
                }  
            }
            break;
        case "select":
            if ($_SESSION["grade"] != "admin") {
                $search = strpos(mb_strtolower($_POST['perform']), "users");
                if($search) {
                    echo "<div class = 'text-danger'>You have no permissions to check table 'Users'</div>";
                    break;
                }
            }
            try {
                $sql = mysqli_query($bd_connect, $_POST['perform']);
                $result = mysqli_fetch_assoc($sql);

                if(isset($result)){
                    echo "<table class = 'table table-bordered'><thead class = 'bg-secondary text-light'><tr>";
                    foreach($result as $key => $value){
                        echo "<td>{$key}</td>";
                    }
                    echo "</tr></thead>";

                    echo "<tbody>";
                    $sql = mysqli_query($bd_connect, $_POST['perform']);
                    while($result = mysqli_fetch_assoc($sql)){
                        echo "<tr>";
                        foreach($result as $key => $value){
                            echo "<td>{$value}</td>";
                        }
                        echo "<tr>";
                    }        
                    echo "</tbody></table>";
                }
                else echo "No data found";
            } catch (Exception $e){
                echo "<script>alert(\"{$e->getMessage()}\")</script>";
            }  
            break;
        default:
            echo "<div class = 'text-danger'>Invalid request</div>";
    }
}
echo "</div>";
include('parts/footer.php');
?>
