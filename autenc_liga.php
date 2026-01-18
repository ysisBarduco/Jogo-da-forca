<?php
if (session_status() == PHP_SESSION_NONE) session_start();

$liga = !empty($_SESSION["liga_id"]);
?>
