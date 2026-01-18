<?php
session_start();
require 'autenc.php';
require 'autenc_liga.php';
require 'db.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$user = $_SESSION['id_user'] ?? null;
if (!$user) {
    die("Usuário não logado.");
}

// Consulta partidas do usuário
$sql = "
    SELECT p.data, p.pontos, p.palavra, p.resultado, l.nome AS liga_nome
    FROM partidas p
    LEFT JOIN liga l ON p.idliga = l.id
    WHERE p.idusuario = ?
    AND p.status = 'fim'
    ORDER BY p.data DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <title>Histórico de Partidas</title>
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
    <main id="pagina-historico">
        <h1 class="historico-title">Histórico de Partidas</h1>

        <div class="historico-container">
            <table class="historico-table">
                <tr class="cabecalho-historico">
                    <th>Data</th>
                    <th>Pontos</th>
                    <th>Palavra Sorteada</th>
                    <th>Resultado</th>
                    <th>Liga</th>
                </tr>

                <?php while($h = $res->fetch_assoc()): ?>
                <tr class="corpo-historico">
                    <td><?= date("d/m/Y H:i", strtotime($h['data'])) ?></td>
                    <td><?= $h['pontos'] ?></td>
                    <td><?= htmlspecialchars($h['palavra'] ?? '-') ?></td>
                    <td><?= ucfirst($h['resultado']) ?></td>
                    <td><?= $h['liga_nome'] ?: 'Nenhuma' ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        
        <section class="sair-historico">
            <button class="botao"><a href="inicio.php">< Voltar</a></button>
            <button class="botao"><a href="pontuacao_semanal.php">Pontos semanais</a></button>
        </section>
    </main>
</body>
</html>
