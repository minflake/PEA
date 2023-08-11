<?php 
    @session_start();
    require("../../conexao.php");

    if (isset($_GET['opcao'])) {
    
        $query = $pdo -> query("SELECT atvd_a_fazer.descricao_atvd as 'Descrição da Atividade', atvd_por_curso.limite_horas_atvd as 'Horas por Atividade', atvd_por_curso.carga_horaria_max as 'Limite de Horas', atvd_a_fazer.categoria_atvd as 'Categoria', atvd_a_fazer.tipo_doc_comprobatorio 'Tipo de Anexo'

        FROM atvd_por_curso
        LEFT JOIN atvd_a_fazer ON atvd_por_curso.cod_atvd = atvd_a_fazer.cod_atvd
        WHERE cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "' AND atvd_por_curso.cod_atvd = '". $_GET['opcao'] . "';");

        $query = $query ->fetchAll(PDO::FETCH_ASSOC);
        
        
        header('Content-Type: application/json');
        echo json_encode($query);
    }
?>