<?php 
    @session_start();
    require_once("../../conexao.php");

    if (!empty($_GET) && isset($_GET["number"])) {
        if (isset($_SESSION["relatorios"])) {
            unset($_SESSION["relatorios"]);
            header('Location: index.php');
        } else {
            header('Location: index.php');
        }
    }
    //VERIFICA SE FOI INFORMADO ALGUM FILTRO - POSSIBILIDADE NULA
    if (empty($_GET)) {
        header('Location: index.php');
    } else {
        if (isset($_GET["curso"])) {
            $curso = $_GET["curso"];
        } else {
            $curso = null;
        }
        if (isset($_GET["disciplina"])) {
            $disciplina = $_GET["disciplina"];
        } else {
            $disciplina = null;
        }
        if (isset($_GET["semestre"])) {
            $semestre = $_GET["semestre"];
        } else {
            $semestre = null;
        }
        if (isset($_GET["status"])) {
            $status = $_GET["status"];
        } else {
            $status = null;
        }

        //VERFICA SE FILTRO CURSO FOI INFORMADO - POSSIBILIDADE 2
        if (isset($curso) && !isset($disciplina) && !isset($semestre) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE curso.cod_curso = '$curso'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }
        
        //VERIFICA SE FITRO DISCIPLINA FOI INFORMADO - POSSIBILIDADE 3
        if (isset($disciplina) && !isset($curso) && !isset($semestre) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.cod_disc = '$disciplina'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITRO SEMESTRE FOI INFORMADO - POSSIBILIDADE 4
        if (isset($semestre) && !isset($disciplina) && !isset($curso) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.semestre = '$semestre'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITRO STATUS FOI INFORMADO - POSSIBILIDADE 5
        if (isset($status) && !isset($disciplina) && !isset($curso) && !isset($semestre)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.status_validacao = '$status'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }
        
        //VERIFICA SE FITROS STATUS E DISCIPLINA FORAM INFORMADOS - POSSIBILIDADE 6
        if (isset($status) && isset($disciplina) && !isset($curso) && !isset($semestre)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.status_validacao = '$status'
            AND relatorio.cod_disc = '$disciplina'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS STATUS E CURSO FORAM INFORMADOS - POSSIBILIDADE 7
        if (isset($status) && isset($curso) && !isset($disciplina) && !isset($semestre)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.status_validacao = '$status'
            AND curso.cod_curso = '$curso'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS STATUS E SEMESTRE FORAM INFORMADOS - POSSIBILIDADE 8
        if (isset($status) && isset($semestre) && !isset($disciplina) && !isset($curso)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.status_validacao = '$status'
            AND relatorio.semestre = '$semestre'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS SEMESTRE E CURSO FORAM INFORMADOS - POSSIBILIDADE 9
        if (isset($semestre) && isset($curso) && !isset($disciplina) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE curso.cod_curso = '$curso'
            AND relatorio.semestre = '$semestre'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS SEMESTRE E DISCIPLINA FORAM INFORMADOS - POSSIBILIDADE 10
        if (isset($semestre) && isset($disciplina) && !isset($curso) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.cod_disc = '$disciplina'
            AND relatorio.semestre = '$semestre'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS DISCIPLINA E CURSO FORAM INFORMADOS - POSSIBILIDADE 11
        if (isset($disciplina) && isset($curso) && !isset($semestre) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.cod_disc = '$disciplina'
            AND curso.cod_curso = '$curso'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

    
        //VERIFICA SE FITROS STATUS, DISCIPLINA E CURSO FORAM INFORMADOS - POSSIBILIDADE 12
        if (isset($status) && isset($disciplina) && isset($curso) && !isset($semestre)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE curso.cod_curso = '$curso'
            AND relatorio.cod_disc = '$disciplina'
            AND relatorio.status_validacao = '$status'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS STATUS, DISCIPLINA E SEMESTRE FORAM INFORMADOS - POSSIBILIDADE 13
        if (isset($status) && isset($disciplina) && isset($semestre) && !isset($curso)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.semestre = '$semestre'
            AND relatorio.cod_disc = '$disciplina'
            AND relatorio.status_validacao = '$status'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }
        //VERIFICA SE FITROS STATUS, CURSO E SEMESTRE FORAM INFORMADOS - POSSIBILIDADE 14
        if (isset($status) && isset($curso) && isset($semestre) && !isset($disciplina)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.semestre = '$semestre'
            AND curso.cod_curso = '$curso'
            AND relatorio.status_validacao = '$status'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE FITROS DISCIPLINA, CURSO E SEMESTRE FORAM INFORMADOS - POSSIBILIDADE 15
        if (isset($disciplina) && isset($curso) && isset($semestre) && !isset($status)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio

		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.semestre = '$semestre'
            AND curso.cod_curso = '$curso'
            AND relatorio.cod_disc = '$disciplina'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }

        //VERIFICA SE TODOS OS FILTROS FORAM INFORMADOS - POSSIBILIDADE 16
        if (isset($status) && isset($disciplina) && isset($curso) && isset($semestre)) {
            $query = $pdo -> query("SELECT aluno.ra, relatorio.cod_relatorio, curso.cod_curso, curso.nome_curso, disciplina.cod_disc, disciplina.nome_disc, aluno.nome, aluno.sobrenome, relatorio.semestre, relatorio.status_validacao, relatorio.horas_enviadas, relatorio.data_envio, conceito.conceito
            FROM relatorio
            
		    LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
            LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
            LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
            LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_relatorio
            WHERE relatorio.semestre = '$semestre'
            AND curso.cod_curso = '$curso'
            AND relatorio.cod_disc = '$disciplina'
            AND relatorio.status_validacao = '$status'
            AND relatorio.status_envio = '1'
            ;");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    
    $_SESSION["relatorios"] = $query;
    //var_dump($_SESSION["relatorios"]);
    header('Location: index.php');

    
?>