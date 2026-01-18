<?php
session_start();
require 'db.php';


$usuario = $_SESSION['id_user'] ?? 0;
    if($usuario == 0){
        die("Você não está logado.");
    }

$sql = "SELECT p.id, l.nome AS liga, p.pontos, p.acertos, p.erros, p.resultado, p.status, p.data
        FROM partidas p
        LEFT JOIN liga l ON p.idliga = l.id
        WHERE p.idusuario = $usuario
        ORDER BY p.data DESC";

$result = mysqli_query($conn, $sql);
if(!$result){
    die("Erro na query: " . mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Partidas</title>
</head>
<body>
<h1>Partidas</h1>

<?php if(mysqli_num_rows($result) > 0): ?>
    <?php while($p = mysqli_fetch_assoc($result)): ?>
        <div>
            <b>Pontos:</b> <?= $p['pontos'] ?> |
            <b>Acertos:</b> <?= $p['acertos'] ?> |
            <b>Erros:</b> <?= $p['erros'] ?> |
            <b>Status:</b> <?= $p['status'] ?> |
            <b>Liga:</b> <?= $p['liga'] ?? 'Nenhuma' ?> |
            <?php if($p['status']=='jogando'): ?>
                <a href="jogo.php?id=<?= $p['id'] ?>">Continuar</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>Nenhuma partida registrada.</p>
  <?php endif; ?>

<br><a href="inicio.php">Voltar</a>
</body>
</html>

