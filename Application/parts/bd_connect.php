<?php
$host = "localhost";
$user_bd = "root";
$pass_bd = "";
$name_bd = "applicationbd";

$bd_connect = new mysqli($host, $user_bd, $pass_bd);
$sql = mysqli_query($bd_connect, "show databases like'applicationbd'");
$result = mysqli_fetch_array($sql);

if(!isset($result[0])) include("bd_create.php");
else $bd_connect = new mysqli($host, $user_bd, $pass_bd, $name_bd);

// $row = 1;
// if (($handle = fopen("file.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//         $num = count($data);
//         echo "<p> $num fields in line $row: <br /></p>\n";
//         $row++;
//         for ($c=0; $c < $num; $c++) {
//             echo $data[$c] . "<br />\n";
//         }
//     }
//     fclose($handle);
// }
?>