<?php
session_start();
unset($_SESSION["liga_id"]);
unset($_SESSION["liga_nome"]);
header("Location: inicio.php");
exit;

?>