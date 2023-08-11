<?php 
    @session_start();
    require("../../conexao.php");

    //CONSULTAR TODAS AS ATIVIDADES FEITAS DO ALUNO
    $query = $pdo -> query("SELECT atvd_feita.cod_atvd_feita, disciplina.nome_disc, atvd_a_fazer.tipo_atvd, atvd_feita.qntd_horas, atvd_feita.horas_validas
    FROM atvd_feita 
    LEFT JOIN disciplina ON atvd_feita.cod_disc = disciplina.cod_disc
    LEFT JOIN atvd_a_fazer ON atvd_feita.cod_atvd = atvd_a_fazer.cod_atvd
    WHERE cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "'
    AND atvd_feita.cod_disc = '" . $_GET['opcao'] . "'
    AND atvd_feita.status_envio = '0';");

    $query = $query -> fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($query);
?>
