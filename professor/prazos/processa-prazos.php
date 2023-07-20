<?php
//SOLICITA A CONEXAO COM O BANCO
require_once("../../conexao.php");
session_start();

//ATRIBUI AS ENTRADAS DO FORMULARIO A VARIAVEIS
$inicio_entregas = $_POST["inicio_entregas"];
$entrega_1 = $_POST["entrega_1"];
$entrega_final = $_POST["entrega_final"];
$fim_semestre = $_POST["fim_semestre"];
$inicio_semestre = $_POST["inicio_semestre"];
$formato_entrada = "d/m/Y";

//TRATA E CONVERTE A ENTRADA "INICIO DAS ENTREGAS"
$inicio_entregas_convertido = DateTime::createFromFormat($formato_entrada, $inicio_entregas);
$inicio_entregas_formatado = $inicio_entregas_convertido -> format('Y-m-d');

//TRATA E CONVERTE A ENTRADA "ENTREGA 1"
$entrega_1_convertido = DateTime::createFromFormat($formato_entrada, $entrega_1);
$entrega_1_formatado = $entrega_1_convertido -> format('Y-m-d');

//TRATA E CONVERTE A ENTRADA "ENTREGA FINAL"
$entrega_final_convertido = DateTime::createFromFormat($formato_entrada, $entrega_final);
$entrega_final_formatado = $entrega_final_convertido -> format('Y-m-d');

//TRATA E CONVERTE A ENTRADA "FINAL DO SEMESTRE"
$fim_semestre_convertido = DateTime::createFromFormat($formato_entrada, $fim_semestre);
$fim_semestre_formatado = $fim_semestre_convertido -> format('Y-m-d');

//TRATA E CONVERTE A ENTRADA "INICIO DO SEMESTRE"
$inicio_semestre_convertido = DateTime::createFromFormat($formato_entrada, $inicio_semestre);
$inicio_semestre_formatado = $inicio_semestre_convertido -> format('Y-m-d');


try {
    $query_guardar_prazos = $pdo -> prepare("UPDATE prazo SET inicio_entrega = :inicio_entregas, entrega_um = :entrega_1, entrega_final = :entrega_final, fim_semestre = :fim_semestre, inicio_semestre = :inicio_semestre WHERE cod_prazo = '1'");

    $query_guardar_prazos -> bindValue(":inicio_entregas", "$inicio_entregas_formatado");
    $query_guardar_prazos -> bindValue(":entrega_1", "$entrega_1_formatado");
    $query_guardar_prazos -> bindValue(":entrega_final", "$entrega_final_formatado");
    $query_guardar_prazos -> bindValue(":fim_semestre", "$fim_semestre_formatado");
    $query_guardar_prazos -> bindValue(":inicio_semestre", "$inicio_semestre_formatado");
    $query_guardar_prazos -> execute();

    $_SESSION['status_formulario'] = true;
    header('Location: index.php');
} catch (Exception $th) {
    $_SESSION['status_formulario'] = false;
    header('Location: index.php');
}

