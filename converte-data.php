<?php 
require_once("conexao.php");

$formato_banco = "Y-m-d";

$query_consulta_prazos = $pdo -> query("SELECT * FROM prazo");
$query_consulta_prazos = $query_consulta_prazos -> fetchAll(PDO::FETCH_ASSOC);


//TRATA E CONVERTE A ENTRADA "INICIO DAS ENTREGAS" PARA STRING
$inicio_entrega_convertido = DateTime::createFromFormat($formato_banco, $query_consulta_prazos[0]['inicio_entrega']);
$inicio_entrega_formatado = $inicio_entregas_convertido -> format('d/m/Y');


//TRATA E CONVERTE A ENTRADA "ENTREGA 1" PARA STRING
$entrega_um_convertido = DateTime::createFromFormat($formato_banco, $query_consulta_prazos[0]['entrega_um']);
$entrega_um_formatado = $entrega_um_convertido -> format('d/m/Y');


//TRATA E CONVERTE A ENTRADA "ENTREGA FINAL" PARA STRING
$entrega_final_convertido = DateTime::createFromFormat($formato_banco, $query_consulta_prazos[0]['entrega_final']);
$entrega_final_formatado = $entrega_final_convertido -> format('d/m/Y');


//TRATA E CONVERTE A ENTRADA "FIM DO SEMESTRE" PARA STRING
$fim_semestre_convertido = DateTime::createFromFormat($formato_banco, $query_consulta_prazos[0]['fim_semestre']);
$fim_semestre_formatado = $fim_semestre_convertido -> format('d/m/Y');


//TRATA E CONVERTE A ENTRADA "INICIO DO SEMESTRE" PARA STRING
$inicio_semestre_convertido = DateTime::createFromFormat($formato_banco, $query_consulta_prazos[0]['inicio_semestre']);
$inicio_semestre_formatado = $inicio_semestre_convertido -> format('d/m/Y');


?>
