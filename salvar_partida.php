<?php
echo "Arquivo foi chamado!";
session_start();
require 'db.php';
require 'autenc.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!isset($_SESSION["id_user"])){
        die("Usuário não cadastrado.");
    }

    $id_user = $_SESSION["id_user"];
    $id_liga = $_SESSION["liga_id"] ?? null;

    $resultado = $_POST["resultado"] ?? '';
    $pontos = $_POST["pontos"] ?? 0;
    $acertos = $_POST["acertos"] ?? 0;
    $erros = $_POST["erros"] ?? 0;
    $palavra = $_POST["palavra_sorteada"] ?? '-';
    
    // Insere a partida completa de uma vez
    $stmt = $conn->prepare(" INSERT INTO partidas  (idusuario, idliga, pontos, acertos, erros, resultado, status, data, palavra) VALUES (?, ?, ?, ?, ?, ?, 'fim', NOW(), ?) ");

    $stmt->bind_param("iiiiiss", $id_user, $id_liga, $pontos, $acertos, $erros, $resultado, $palavra);
    $stmt->execute();

    if ($stmt->error) {
        die("ERRO NO INSERT: " . $stmt->error);
    }

    $stmt->close();

    // Atualiza pontuação da liga (se houver)
    if($id_liga){
        $stmtLiga = $conn->prepare(" INSERT INTO pontuacao_liga (idliga, idusuario, pontos, datahora) VALUES (?, ?, ?, NOW())  ON DUPLICATE KEY UPDATE pontos = pontos + VALUES(pontos), datahora = VALUES(datahora)  ");
        
        $stmtLiga->bind_param("iii", $id_liga, $id_user, $pontos);
        $stmtLiga->execute();
        $stmtLiga->close();
    }

}

?>

