<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require "db.php";

    $nome = $_POST["nome"];
    $senha = $_POST["senha"];
    $confirmar = $_POST["confirmar"];

    $nome_seguro = mysqli_real_escape_string($conn, $nome);
    $verificar = "SELECT id FROM liga WHERE nome = '$nome_seguro'";

    $resultado = mysqli_query($conn,$verificar);

    if(mysqli_num_rows($resultado) > 0){

        echo "<p style='color:red;'>Essa liga já esta cadastrada!<p>";
    }else{

        if($senha != $confirmar){
        echo "<p style='color:red;'>As senhas diferentes.</p>";

        } else {
            
            $criptografada = md5($senha);


            $sql = "INSERT INTO liga (nome, senha) VALUES ('$nome_seguro', '$criptografada')";

            if(mysqli_query($conn, $sql)){
                echo "<p>Liga criada com sucesso!</p>";
            } else {
                echo "<p style='color:red;'>Erro: " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <title>Cadastrar</title>
</head>
<body>
   <div class="registro">
        <h2>Criar liga</h2><br>

        <form action="liga_register.php" method="POST">  
        <label>Nome: <input type="text" name="nome" required><br></label>
        <label>Senha: <input type="password" name="senha" required><br></label>
        <label>Confirmar senha: <input type="password" name="confirmar" required></label><br>
        

        <br>
        <a class="entrar" href="liga.php">Voltar</a>

       <input class="entra" type="submit" value="Criar">

        </form>
</div>
</body>
</html>