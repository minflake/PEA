<?php 
    @session_start();
    require_once("../../conexao.php");

    $tipo_atividade = $_POST["tipoAtividade"];
    $categoria = $_POST["categoria"];
    $descricao_atividade = $_POST["descricaoAtividade"];
    $tipo_documento = $_POST["tipoDocumento"];
    $limite_horas = $_POST["limiteHoras"];
    $carga_max = $_POST["cargaMax"];
    $contador = $_POST["contador"];
    
    $cursos = array();
    for ($i=0; $i < $contador; $i++) { 
        $cursos[] = $_POST["curso_$i"];
    }

    var_dump($tipo_atividade);
    var_dump($categoria);
    var_dump($descricao_atividade);
    var_dump($tipo_documento);
    var_dump($limite_horas);
    var_dump($carga_max);
    var_dump($cursos);
  
    try {
        //GUARDAR DADOS NO BANCO
        $query_guarda_dados_atividades = $pdo -> prepare("INSERT INTO atvd_a_fazer SET cod_professor = :cod_professor, tipo_atvd = :tipo_atvd, descricao_atvd = :descricao_atvd, categoria_atvd = :categoria_atvd, tipo_doc_comprobatorio = :doc;");

        $query_guarda_dados_atividades -> bindValue(":cod_professor", $_SESSION["dados_usuario"][0]["cod_professor"]);
        $query_guarda_dados_atividades -> bindValue(":tipo_atvd", "$tipo_atividade");
        $query_guarda_dados_atividades -> bindValue(":descricao_atvd", "$descricao_atividade");
        $query_guarda_dados_atividades -> bindValue(":categoria_atvd", "$categoria");
        $query_guarda_dados_atividades -> bindValue(":doc", "$tipo_documento");
        $query_guarda_dados_atividades -> execute();

        $query = $pdo -> query("SELECT MAX(atvd_a_fazer.cod_atvd) AS cod_atvd FROM atvd_a_fazer;");
        $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        $cod_atvd = $query[0]["cod_atvd"];

        foreach ($cursos as $curso) {
                $query = $pdo -> prepare("INSERT INTO atvd_por_curso SET cod_curso = :cod_curso, cod_atvd = :cod_atvd, carga_horaria_max = :carga_max, limite_horas_atvd = :limite_horas;");
                
                $query -> bindValue(":cod_curso", "$curso");
                $query -> bindValue(":cod_atvd", "$cod_atvd");
                $query -> bindValue(":carga_max", "$carga_max");
                $query -> bindValue(":limite_horas", "$limite_horas");
                $query -> execute();
        }
        
        $_SESSION['status_formulario'] = true;
        header('Location: cadastrar-atividades.php');
    } catch (\Throwable  $th) {
        echo $th;
        $_SESSION['status_formulario'] = false;
        header('Location: cadastrar-atividades.php');
    }

?>