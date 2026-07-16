<?php
$host ="localhost";
$user ="joegaza_basma";
$passward ="nokwem-zibbAd-zaxba0";
$database = "joegaza_basma";
$conn=mysqli_connect($host,$user,$passward,$database);
if(!$conn){
    die("connection failed: ".mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>