<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require "db.php";

    $nome = $_POST["name"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $confirmar = $_POST["confirmar"];

    $verificar = "SELECT id FROM usuario WHERE email = '$email'";
    $resultado = mysqli_query($conn,$verificar);

    if(mysqli_num_rows($resultado) > 0){
        echo "<p style='color:red;'>Este email já está cadastrado!<p>";
    }else{

        if($senha != $confirmar){
        echo "<p style='color:red;'>As senhas diferentes.</p>";

        } else {
            
            $criptografada = md5($senha);


            $sql = "INSERT INTO usuario (nome, email, senha)
                    VALUES ('$nome', '$email', '$criptografada')";

            if(mysqli_query($conn, $sql)){
                echo "<p>Usuário cadastrado com sucesso!</p>";
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
        <h2>Fazer cadastro</h2><br>

        <form action="register.php" method="POST">
        <label>Nome: <input type="text" name="name" required><br></label>
        <label>Email: <input type="text" name="email" required><br></label>
        <label>Senha: <input type="password" name="senha" required><br></label>
        <label>Confirmar senha: <input type="password" name="confirmar" required></label><br>

        <input class="entrar" type="submit" value="Cadastrar">
        <br>
       
        </form>

        
        <button class="entra"> <a  href="logar.php">Voltar ao Login</a></button>
      
        
</div>
</body>
</html>
