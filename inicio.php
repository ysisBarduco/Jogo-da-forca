<?php 
  require "autenc_liga.php";
  require "autenc.php";
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title> Jogo da Forca</title> 
        
        <link rel="stylesheet" type="text/css" href="estilo.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    </head>


    <body>
        <header class="l">
            <ul>    
                <?php if ($login): echo("Você está logado!");?>
                    <button class="cabecalho"><a href="logout.php" >Logout</a></button>
                <?php else:?>
                    <button class="cabecalho"><a href="logar.php">Logar</a></button>
                <?php endif;?>
            </ul>

            <?php if ($liga): echo("Você está em uma liga!") ?>
                <button class="cabecalho"><a href="logout_liga.php" >Logout liga</a></button>
            <?php endif;?>
        </header>

            
            <div class="la">

                <?php if ($login):?>
                    <button class="botao"><a href="jogo.php">Jogar</a></button>
                    <button class="botao"><a href="ranking_geral.php">Ranking</a></button>

                    <?php if($liga): ?>
                        <button class="botao"><a href="ranking_liga.php">Ranking liga</a></button>
                    <?php endif;?>

                    <button class="botao"><a href="liga.php">Entrar / Criar liga</a></button>
                    <button class="botao"><a href="historico.php">Histórico de Partidas</a></button><br><br>

                <?php else:?>
                    <p>Você precisa logar!</P>
                <?php endif;?>
           </div>

        <div class= "conteiner">
            <img class="forca" src="img/forca.png" alt="Forca"> 
            <img class="gifi" src="img/0.gif" alt="Título"><br><br>
        </div>        

        <div class="la"><img class="gif" src="img/3.gif" alt="Teclado"></div>

    </body>
</html>