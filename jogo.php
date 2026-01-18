<?php
require 'autenc.php';
require 'autenc_liga.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Jogo da Forca</title>
</head>
<body>
    <header>
        <button class="cabecalho"><a href="inicio.php">Inicio</a></button>
        <button class="cabecalho"><a href="ranking_geral.php">Ranking</a></button>
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

    <main id="pagina-jogo">

        <section class="conteudo" id="emoji-container">
            <h2 id="emoji">&#128528;</h2>
        </section>
        
        <form action="jogo.html" class="conteudo" id="guess-container">
        </form>

        <section class="conteudo" id="forca">
            <h2 id="placar-forca">0/10</h2>
            <ul class="lista-erros">
            </ul>
        </section>

        <script src="jogo.js"></script>
    </main>
    
</body>
</html>