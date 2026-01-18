<?php
session_start();
require "db.php";
require "autenc.php";

if (!$login) {
    die("Você precisa estar logado.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $senha = md5($_POST["senha"]);
    $id_usuario = $_SESSION["id_user"];

    $sql = "SELECT * FROM liga WHERE nome = '$nome' AND senha = '$senha'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {

        $liga = mysqli_fetch_assoc($resultado);
        $id_liga = $liga["id"];

        $sql2 = "INSERT INTO liga_usuario (idliga, idusuario) VALUES ('$id_liga', '$id_usuario')";
        mysqli_query($conn, $sql2);

        $_SESSION["liga_id"] = $id_liga;
        $_SESSION["liga_nome"] = $nome;

        header("Location: inicio.php");
        exit;

    } else {
        echo "Nome ou senhas incorretos!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Criar/entrar em liga</title>
</head>
 <body>
    <div class="escolha">

        <h1>Bem-vindo!</h1>
      
        <body>
            <h2>Entrar na liga</h2><br>

            <form action="liga.php" method="POST">
            <label>Nome: <input type="text" name="nome" required><br></label>
            <label>Senha: <input type="password" name="senha"   required><br></label><br>

          <input class="entra" type="submit" value="Entrar">
            </form>
        </body>
        <ul>
           <button class="entrar"><a href="inicio.php">Voltar</a></button>
           <button class="entrar"><a href="liga_register.php">Criar liga</a></button>
           
        </ul>
    </div>
 </body>
</html>