<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teste";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Erro ao conectar: " . mysqli_connect_error());
}
?>
