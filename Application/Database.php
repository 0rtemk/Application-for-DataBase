<?php
include('parts/bd_connect.php');
include('parts/header.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
}

echo "<h1 class = 'text-center py-2'>Database</h1>";
?>
<div class="text-center mx-5 pb-1">
    <div class="border border-primary rounded p-3">
        <div class="container">
            <div class="row">
                <div class="col-sm text-center">
                    <a href="tables/managers.php" type="button" class="btn btn-secondary">Managers</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/outgoing.php" type="button" class="btn btn-secondary">Outgoing</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/incoming.php" type="button" class="btn btn-secondary">Incoming</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/products.php" type="button" class="btn btn-secondary">Products</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/groups.php" type="button" class="btn btn-secondary">Groups</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/contragents.php" type="button" class="btn btn-secondary">Contragents</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/taxes.php" type="button" class="btn btn-secondary">Taxes</a>
                </div>
                <div class="col-sm text-center">
                    <a href="tables/prices.php" type="button" class="btn btn-secondary">Prices</a>
                </div>
                <?php
                    if($_SESSION["grade"] == "admin") echo
                    "<div class='col-sm text-center'>
                        <a href='tables/users.php' type='button' class='btn btn-secondary'>Users</a>
                    </div>";
                ?>
            </div>
        </div>
    </div>
</div>
<div class="text-center mx-5 pb-5">
    <div class="border border-primary rounded p-3">
        <img src="parts/bdScheme.png" class="rounded mx-auto d-block" alt="Responsive image" width="60%" height="60%">
    </div>
</div>
<?php

include('parts/footer.php');
?>