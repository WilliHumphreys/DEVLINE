<?php
    try {
        $pdo = new PDO("mysql:dbname=devline;host=localhost", "root", "");
    } catch (\Throwable $th) {
        header("Location: ../view/error_conexao.html");
    }
?>