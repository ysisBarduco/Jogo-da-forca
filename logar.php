<?php

session_start(); 
require 'autenc.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
  require "db.php";

    $email = $_POST["email"];
    $senha = md5($_POST["senha"]);

    $sql = "SELECT * FROM usuario WHERE email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $_SESSION["id_user"] = $user["id"];
        $_SESSION["user"] = $user["nome"];
        header("Location: inicio.php");
        exit();

    } else {
        echo "<p>Email ou senha incorretos.</p>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Logar ou Cadastrar</title>
</head>
 <body>
    <div class="escolha">

        <h1>Bem-vindo!</h1>
      
        <body>
            <h2>Login</h2><br>

            <form action="logar.php" method="POST">
            <label>Email: <input type="text" name="email" required><br></label>
            <label>Senha: <input type="password" name="senha"   required><br></label><br>

          <input class="entra" type="submit" value="Entrar">
            </form>
        </body>
        <ul>
           <button class="entrar"><a href="inicio.php">Voltar</a></button>
           <button class="entrar"><a href="register.php">Cadastrar Usuário</a></button>
           
        </ul>
    </div>
 </body>
</html>
