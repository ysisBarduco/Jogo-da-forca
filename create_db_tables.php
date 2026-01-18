<?php
require 'db.php';

// Conexão
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Palavras secretas a serem inseridas
$inserir_palavras = [
    [
        'palavra' => 'COMPUTADOR'
    ],
    [
        'palavra' => 'SUL'
    ],
    [
        'palavra' => 'FAUNA'
    ],
    [
        'palavra' => 'ALMA'
    ],
    [
        'palavra' => 'VIDRO'
    ],
    [
        'palavra' => 'VIDEO'
    ],
    [
        'palavra' => 'FRIO'
    ],
    [
        'palavra' => 'PLACA'
    ],
    [
        'palavra' => 'DISCO'
    ],
    [
        'palavra' => 'PNEUMOULTRAMICROSCOPICOSSILICOVULCANOCONIOTICO'
    ],
    [
        'palavra' => 'OESTE'
    ],
    [
        'palavra' => 'LOBO'
    ],
    [
        'palavra' => 'GATO'
    ],
    [
        'palavra' => 'SOL'
    ],
    [
        'palavra' => 'LUA'
    ],
    [
        'palavra' => 'FLORA'
    ],
    [
        'palavra' => 'FORNALHA'
    ],
    [
        'palavra' => 'CHALEIRA'
    ],
];

// Criar o banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar o banco de dados: " . mysqli_error($conn));
}

// Selecionar o banco de dados
$sql = "USE $dbname";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao selecionar o banco de dados: " . mysqli_error($conn));
}

// Criar tabelas:
// usuario, para armazenar o login do jogador
$sql = "CREATE TABLE IF NOT EXISTS usuario (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela usuario: " . mysqli_error($conn));
}

// pontuação de cada jogador, para realizar o ranking geral
$sql = "CREATE TABLE IF NOT EXISTS pontuacao_geral (
        id INT AUTO_INCREMENT PRIMARY KEY,
        idusuario INT NOT NULL,
        pontos INT,
        FOREIGN KEY (idusuario) REFERENCES usuario(id)
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela pontuacao_geral: " . mysqli_error($conn));
}

// Adicona a coluna datahora caso ela não tenha sido adicionada
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM pontuacao_geral LIKE 'datahora'");
if(mysqli_num_rows($check_column) == 0){
    mysqli_query($conn, "ALTER TABLE pontuacao_geral ADD datahora DATETIME NULL");
}

// liga
$sql = "CREATE TABLE IF NOT EXISTS liga (
        id INT AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        idusuario INT,
        data_criada DATETIME NOT NULL,
        FOREIGN KEY (idusuario) REFERENCES usuario (id)
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela liga: " . mysqli_error($conn));
}

// pontuacao_liga, tabela relacionamento entre as ligas e seus membros, e a pontuação de cada jogador para realizar o ranking da liga
$sql = "CREATE TABLE IF NOT EXISTS pontuacao_liga (
        idliga INT NOT NULL,
        idusuario INT NOT NULL,
        pontos INT,
        PRIMARY KEY (idliga, idusuario),
        FOREIGN KEY (idliga) REFERENCES liga(id),
        FOREIGN KEY (idusuario) REFERENCES usuario(id)
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela pontuacao_liga: " . mysqli_error($conn));
}


$sql = "CREATE TABLE IF NOT EXISTS liga_usuario(
        id INT AUTO_INCREMENT,
        idliga INT NOT NULL,
        idusuario INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (idliga) REFERENCES liga(id),
        FOREIGN KEY (idusuario) REFERENCES usuario(id)
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela liga_usuario: " . mysqli_error($conn));
}

// Adicona a coluna datahora caso ela não tenha sido adicionada
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM pontuacao_liga LIKE 'datahora'");
if(mysqli_num_rows($check_column) == 0){
    mysqli_query($conn, "ALTER TABLE pontuacao_liga ADD datahora DATETIME NULL");
}

$sql = "CREATE TABLE IF NOT EXISTS partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idusuario INT NOT NULL,
    idliga INT DEFAULT NULL,
    pontos INT NOT NULL DEFAULT 0,
    acertos INT DEFAULT 0,
    erros INT DEFAULT 0,
    resultado VARCHAR(50) DEFAULT NULL,
    status ENUM ('jogando','fim') DEFAULT 'jogando',
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idliga) REFERENCES liga(id),
    FOREIGN KEY (idusuario) REFERENCES usuario(id)
);";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela partidas: " . mysqli_error($conn));
}

// Adicona a coluna palavra caso ela não tenha sido adicionada
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM partidas LIKE 'palavra'");
if(mysqli_num_rows($check_column) == 0){
    mysqli_query($conn, "ALTER TABLE partidas ADD palavra VARCHAR(255) DEFAULT NULL");
}

// palavra_secreta, tabela para armazenar as palavras secretas
$sql = "CREATE TABLE IF NOT EXISTS palavra_secreta (
        id INT AUTO_INCREMENT PRIMARY KEY,
        palavra VARCHAR(255)
    );";
if(!mysqli_query($conn, $sql)) {
    die("Falha ao criar tabela palavra_secreta: " . mysqli_error($conn));
}

// Adiciona a restrição unique a palavra, para que não haja duplicatas
$sql = "ALTER TABLE palavra_secreta ADD UNIQUE (palavra)";
if(!mysqli_query($conn, $sql)){
    die("Falha ao adicionar restrição UNIQUE em palavra: " . mysqli_error($conn));
}


// Insere as palavras secretas a tabela
foreach($inserir_palavras as $palavra){
    $sql = "INSERT IGNORE INTO palavra_secreta (palavra) VALUES ('" . $palavra['palavra'] . "')";

    if(!mysqli_query($conn,$sql)){
    die("Erro ao inserir as palavras: " . mysqli_error($conn));
  }
}


?>