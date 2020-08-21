<?php
 
$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "lifescoin";
 
$conn = mysqli_connect($servername,$dBUsername,$dBPassword,$dBName);
 
if (!$conn)
{
    alert("hi");
    die("Connection failed:".mysqli_connect_error());
}
?>