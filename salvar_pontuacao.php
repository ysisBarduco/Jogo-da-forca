<?php
require 'db.php';

// Verificar sessão
session_start();
require 'autenc.php';

// Conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if (!isset($_SESSION["id_user"])){
        die("Usuário não cadastrado.");
    }

    // Recebe os dados
    $id_usuario = $_SESSION["id_user"];
    $pontos = $_POST["pontos_partida"];
    $data_hora = $_POST["data_hora"];
    
    // Prepared statement
    $stmt = $conn->prepare("INSERT INTO pontuacao_geral(idusuario, pontos, datahora) VALUES (?, ?, ?)");
    $stmt -> bind_param("iis", $id_usuario, $pontos, $data_hora);
    $stmt -> execute();
    $stmt->close();

    if(isset($_SESSION["liga_id"]) && $_SESSION["liga_id"] != null){
    $idliga = $_SESSION["liga_id"];
    
    $stmtLiga = $conn->prepare("INSERT INTO pontuacao_liga (idliga, idusuario, pontos, datahora) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE pontos = pontos + VALUES(pontos), datahora = VALUES(datahora)");
    $stmtLiga->bind_param("iii", $idliga, $id_usuario, $pontos);
    $stmtLiga->execute();
    $stmtLiga->close();
}
    
$conn->close();

}
?>