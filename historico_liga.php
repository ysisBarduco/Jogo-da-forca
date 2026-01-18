<?php
session_start();
require 'db.php';
require 'autenc.php';

$liga_id = $_SESSION['liga_id'] ?? null;
if (!$liga_id) die("Você não está em uma liga.");

// Dados da liga
$sql = "SELECT nome, data_criada FROM liga WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $liga_id);
$stmt->execute();
$res = $stmt->get_result();
$liga = $res->fetch_assoc();
$stmt->close();

// Pontos totais da liga
$sql = "SELECT SUM(pontos) AS total FROM pontuacao_liga WHERE idliga = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $liga_id);
$stmt->execute();
$res = $stmt->get_result();
$pts = $res->fetch_assoc();
$stmt->close();

// Partidas da liga
$sql = " SELECT p.data, p.palavra, p.pontos, p.resultado, u.nome AS jogador
    FROM partidas p
    LEFT JOIN usuario u ON p.idusuario = u.id
    WHERE p.idliga = ? AND p.status = 'fim'
    ORDER BY p.data DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $liga_id);
$stmt->execute();
$res = $stmt->get_result();
$stmt->close();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Histórico da Liga</title>
    <link rel="stylesheet" href="estilo.css">
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

    <main id="pagina-historico-liga">
        <h1 class="historico-title">Histórico da Liga</h1>
        
        <div class="liga-informacao">
            <p><b>Liga:</b> <?= htmlspecialchars($liga['nome']) ?></p>
            <p><b>Criada em:</b> <?= $liga['data_criada'] ?></p>
            <p><b>Pontos totais:</b> <?= $pts['total'] ?? 0 ?></p>
        </div>

        <h2 class="historico-title">Partidas</h2>
        <table class="historico-table">
            <tr class="cabecalho-historico">
                <th>Data</th>
                <th>Jogador</th>
                <th>Palavra Sorteada</th>
                <th>Pontos</th>
                <th>Resultado</th>
            </tr>
            <?php while($p = $res->fetch_assoc()): ?>
            <tr class="corpo-historico">
                <td><?= $p['data'] ?></td>
                <td><?= htmlspecialchars($p['jogador']) ?></td>
                <td><?= htmlspecialchars($p['palavra'] ?? '-') ?></td>
                <td><?= $p['pontos'] ?></td>
                <td><?= ucfirst($p['resultado']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <section class="sair-historico">
            <button class="botao"><a href="ranking_liga.php">< Voltar</a></button>
        </section>
    </main>

</body>
</html>
