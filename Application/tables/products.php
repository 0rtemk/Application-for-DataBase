<?php
include('../parts/bd_connect.php');
include('../parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/Application/login.php");
}

if (isset($_POST["change"])) {
    header("Location: productsUpdate.php" . $_POST["change"]);
}

if (isset($_POST["delete"])) {
    $sql = 'DELETE FROM products WHERE Prod_id = ' . $_POST["delete"] . '';
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
    $Group_id = $_POST['Group_id'];
    $Prod_name = $_POST['Prod_name'];
    $Expire_time = $_POST['Expire_time'];
    if (isset($_POST['Descriptions'])) $Descriptions = $_POST['Descriptions'];
    else $Descriptions = NULL;

    $sql = "INSERT INTO products(Group_id, Prod_name, Descriptions, Expire_time) VALUES ('$Group_id',  '$Prod_name', '$Descriptions', '$Expire_time')";
    try{
        $bd_connect->query($sql);
    } catch (Exception $e){
        echo "<script>alert(\"{$e->getMessage()}\")</script>";
    }  
    header("Refresh:0");
}

echo"
<form action='products.php' method='post'>
    <div class='row justify-content-begin px-5'>
        <div class='col-auto text-center'>
            <button class='btn btn-sm btn-outline-primary' type='submit' name = 'Return'><<< back</button>
        </div>
    </div>
</form>
";

if ($_SESSION["grade"] == "admin") echo
"<h2 class='text-center p-1'>Products</h2>

<div class='text-center mx-5 pb-5'>
    <div class='border border-primary rounded p-3'>
        <form action='products.php' method='post'>
            <table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'> Group id </th>
                        <th scope='col'> Name </th>
                        <th scope='col'> Description </th>
                        <th scope='col'> Expire_time </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Group_id' pattern = '[0-9]{,5}' placeholder = '0' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Prod_name' pattern = '^[A-Za-zА-Яа-яЁё\s]+$' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Descriptions' id = 'Descriptions' required>
                            </div>
                        </td>
                        <td>
                            <div class='text-center'>
                                <input type='text' class='form-control' name='Expire_time' pattern = '[0-9]{,4}' required>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type='submit' class='btn btn-outline-primary' name = 'Insert'>Add Product</button>
        </form>
    </div>
</div>";
?>
<form action="products.php" method="post">
    <div class="row justify-content-end px-5">
        <div class="col-auto text-center">
            <p class=''>Order by: </p>
        </div>
        <div class="col-auto text-center">
            <select class="form-control form-control-sm" name = 'col'>
                <option>Product id</option>
                <option>Group id</option>
                <option>Name</option>
                <option>Expire time</option>
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
            <th scope='col'> Contragent id </th>
            <th scope='col'> Group id </th>
            <th scope='col'> Name </th>
            <th scope='col'> Description </th>
            <th scope='col'> Expire_time </th>
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

            if($col == "Product id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Prod_id asc');
            else if($col == "Product id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Prod_id desc');
            else if($col == "Group id" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Group_id asc');
            else if($col == "Group id" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Group_id desc');
            else if($col == "Name" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Prod_name asc');
            else if($col == "Name" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Prod_name desc');
            else if($col == "Expire time" && $order == "ascending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Expire_time asc');
            else if($col == "Expire time" && $order == "descending") $sql = mysqli_query($bd_connect, 'SELECT * FROM products order by Expire_time desc');
        }
        else $sql = mysqli_query($bd_connect, 'SELECT * FROM products');

        while ($result = mysqli_fetch_array($sql)) {
            echo
            "<tr><td>{$result['Prod_id']}</td>
            <td>{$result['Group_id']}</td>
            <td>{$result['Prod_name']}</td>
            <td>{$result['Descriptions']}</td>
            <td>{$result['Expire_time']}</td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'productsUpdate.php' method = 'post'>
                    <button class='btn btn-sm btn-outline-primary' type='submit' value = {$result['Prod_id']} name = 'change'>Change</button>
                </form>
            </td>";
            if ($_SESSION["grade"] == "admin") echo
            "<td class = 'text-center'>
                <form action = 'products.php' method = 'post'>
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