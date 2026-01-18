<?php
require 'db.php';

// Conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Seleciona as palavras no banco de dados
$sql = "SELECT palavra FROM palavra_secreta";
$resultado = mysqli_query($conn, $sql);

$palavras = [];

while($row = mysqli_fetch_assoc($resultado)){
    $palavras[] = $row;
}

mysqli_close($conn);

//Transforma os dados recebidos em JSON
header('content-Type: application/json');
echo json_encode($palavras);
?>