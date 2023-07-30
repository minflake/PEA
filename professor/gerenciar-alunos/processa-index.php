<?php 
    if (isset($_POST['ra'])) {
        require_once("../../conexao.php");
        $ra = $_POST['ra'];

        $query_pega_aluno = $pdo -> query("SELECT * FROM ALUNO WHERE ra = '$ra'");
        $query_pega_aluno = $query_pega_aluno -> fetchAll(PDO::FETCH_ASSOC);

        @session_start();
        $_SESSION["cod_aluno"] = $query_pega_aluno[0]["cod_aluno"];
        $cod_aluno = $query_pega_aluno[0]["cod_aluno"];

        echo $cod_aluno;
    }

    if (isset($_GET['pesquisar'])) {
        require_once("../../conexao.php");
        @session_start();
        $_SESSION['input_pesquisa'] = $_GET['pesquisar'];
        $input_pesquisa = $_GET['pesquisar'];

        $query_pesquisar_alunos = $pdo -> query("SELECT
        
            aluno.cod_aluno,
            aluno.ra,
            aluno.nome,
            aluno.sobrenome,
            aluno.data_criacao,
            curso.nome_curso,
            disc_matriculada.cod_conceito,
            disc_matriculada.status_matricula,
            GROUP_CONCAT(DISTINCT disciplina.nome_disc  SEPARATOR ', ') AS nome_disc
                    
            FROM aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disc_matriculada ON disc_matriculada.cod_aluno = aluno.cod_aluno
            LEFT JOIN disciplina ON disciplina.cod_disc = disc_matriculada.cod_disc

            WHERE cpf LIKE '%$input_pesquisa%'
            OR ra LIKE '%$input_pesquisa%'
            OR nome LIKE '%$input_pesquisa%'
            OR sobrenome LIKE '%$input_pesquisa%'
            
            GROUP BY
            aluno.ra;
        ");
        $_SESSION['resultados'] = $query_pesquisar_alunos -> fetchAll(PDO::FETCH_ASSOC);
        header('Location: index.php');
    }
        
?>
