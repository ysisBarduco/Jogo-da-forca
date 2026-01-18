<?php
require 'autenc.php';
include 'db.php';


$liga = $_SESSION['liga_id'] ?? null;

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$result = null;

if ($liga) {

    $sql = "SELECT usuario.nome, SUM(pontuacao_liga.pontos) AS pontuacao_total
            FROM usuario
            JOIN pontuacao_liga ON pontuacao_liga.idusuario = usuario.id
            WHERE pontuacao_liga.idliga = ?
            GROUP BY usuario.id
            ORDER BY pontuacao_total DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $liga);
    $stmt->execute();
    $result = $stmt->get_result();
}


$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Ranking da Liga</title>
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

    <main id="pagina-ranking-liga">
        <h1 class="ranking-title">Ranking da Liga</h1>

        <?php if(isset($result) && mysqli_num_rows($result)>0): ?>
            <?php $posicao=1; 
            
            while($r=mysqli_fetch_assoc($result)): ?>

                <div class="ranking-box" id="ranking-<?= $posicao?>">
                    <span><?= $posicao?>º</span>
                    <span><?= $r['nome'];?></span>
                    <span><?= $r['pontuacao_total'];?></span>
                </div>

            <?php $posicao++; 
            
            endwhile; ?>

        <?php else: ?>
            <p>Nenhuma pontuação registrada nesta liga.</p>
        <?php endif; ?>

        <section class="sair-ranking-liga">
            <button class="botao"><a href="inicio.php">< Voltar</a></button>
            <button class="botao"><a href="historico_liga.php">Histórico de Partidas</a></button>
        </section>
    </main>
</body>
</html>
