<?php 
    $banco = 'pea';
    $usuario = 'root';
    $senha = '';
    $servidor = 'localhost';

    date_default_timezone_set('America/Sao_Paulo');

    try {
        $pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
        // Define a timezone para a conexão atual (exemplo: UTC)
        $query = $pdo -> query("SET time_zone = '-03:00';");
        $query = $query -> fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $erro) {
        echo "Não conectado ao Banco de Dados <br><br> $erro";
    }
?>