<?php
session_start();
require 'db.php';
require 'autenc.php';

$user = $_SESSION['id_user'];
$liga = $_SESSION['liga_id'] ?? null;

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) die("Falha na conexão: " . mysqli_connect_error());


$liga_semanal = 0;

if ($liga) {
    $sql = "SELECT SUM(pontos) AS pontuacao_semanal
            FROM pontuacao_liga
            WHERE idusuario = ?
              AND idliga = ?
              AND datahora >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user, $liga);
    $stmt->execute();
    $stmt->bind_result($liga_semanal);
    $stmt->fetch();
    $stmt->close();
}

// Pontuação semanal geral
$geral_semanal = 0;
$sql2 = "SELECT SUM(pontos) AS pontuacao_semanal
         FROM pontuacao_geral
         WHERE idusuario = ?
           AND datahora >= DATE_SUB(NOW(), INTERVAL 7 DAY)";

$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("i", $user);
$stmt2->execute();
$stmt2->bind_result($geral_semanal);
$stmt2->fetch();
$stmt2->close();

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title> Jogo da Forca</title> 
        
        <link rel="stylesheet" type="text/css" href="estilo.css">
    </head>

    <body>
        <header>
        <button class="cabecalho"><a href="inicio.php">Inicio</a></button>
        <button class="cabecalho"><a href="jogo.php">Jogo</a></button>
        <ul class="l">    
            <?php if ($login): echo("Você está logado!");?>
                <button class="cabecalho"><a href="logout.php" >Logout</a></button>
            <?php else:?>
                <button class="cabecalho"><a href="logar.php">Logar</a></button>
            <?php endif;?>

            <?php if ($liga): echo("Você está em uma liga!") ?>
                <button class="cabecalho"><a href="logout_liga.php">Logout liga</a></button>
            <?php endif;?>
        </ul>
        </header>

        <main class="pagina-semanal">
        <h1 id="semanal-title">Pontuação Semanal</h1>
        
        <div class="semanal-container">
            <p><strong>Na sua liga:</strong> <?= $liga_semanal ?? 0 ?> pontos</p>
            <p><strong>Geral:</strong> <?= $geral_semanal ?? 0 ?> pontos</p>
        </div>

        <button class="botao" id="voltar-historico"><a href="historico.php">< Voltar</a></button>
        </main>
    </body>

</html>