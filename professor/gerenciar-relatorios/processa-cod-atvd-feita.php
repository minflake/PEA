<?php 
    @session_start();
    require("../../conexao.php");

    $cod_atvd_feita = $_GET["cod_atvd_feita"];
    header('Content-Type: application/json');
    echo json_encode($cod_atvd_feita);

?>