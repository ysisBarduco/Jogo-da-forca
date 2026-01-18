<?php
require 'autenc.php';
include 'db.php';

// Conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$sql = "SELECT usuario.nome, SUM(pontuacao_geral.pontos) AS pontuacao_total
        FROM usuario
        JOIN pontuacao_geral ON pontuacao_geral.idusuario = usuario.id
        GROUP BY usuario.id
        ORDER BY pontuacao_total DESC;";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Ranking geral</title>
</head>
<body>
    <header>
        <button class="cabecalho"><a href="inicio.php">Inicio</a></button>
        <ul class="l">    
            <?php if ($login): echo("Você está logado!");?>
                <button class="cabecalho"><a href="logout.php" >Logout</a></button>
            <?php else:?>
                <button class="cabecalho"><a href="logar.php">Logar</a></button>
            <?php endif;?>
        </ul>
    </header>

    <main id="pagina-ranking-geral">

        <h1 class="ranking-title">Ranking Geral</h1>

        <?php 
        $posicao = 1; // Contador para a posição

        while($row = $result -> fetch_assoc()):
        ?>    

        <div class="ranking-box" id="ranking-<?= $posicao?>">
            <span><?= $posicao?>º</span>
            <span><?= $row['nome']?></span>
            <span><?= $row['pontuacao_total']?></span>
        </div>

        <?php 
        $posicao++;

        endwhile; 
        ?>

    </main>
</body>
</html>