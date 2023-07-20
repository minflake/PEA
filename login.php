<?php 
    //INICIAR CONEXAO COM O BANCO DE DADOS
    require_once ("conexao.php");

    //INCIAR SESSÃO
    @session_start();

    //RECEBE OS DADOS ENTRADOS PELO FORMULARIO DE LOGIN NO INDEX
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    //CONSULTA E VERIFICA SE OS DADOS INSERIDOS EXISEM NO BANCO
    $query_pega_cpf = $pdo -> prepare ("SELECT usuario.cod_usuario, usuario.senha, usuario.perfil, usuario.status_usuario,
        COALESCE (professor.cpf, aluno.cpf, adm.cpf) AS cpf

        FROM usuario
        LEFT JOIN professor ON usuario.cod_usuario = professor.cod_usuario
        LEFT JOIN aluno ON usuario.cod_usuario = aluno.cod_usuario
        LEFT JOIN adm ON usuario.cod_usuario = adm.cod_usuario
        WHERE (professor.cpf = :cpf OR aluno.cpf = :cpf OR adm.cpf = :cpf)
        AND usuario.senha = :senha");

        $query_pega_cpf -> bindValue(":cpf", "$cpf");
        $query_pega_cpf -> bindValue(":senha", "$senha");
        $query_pega_cpf -> execute(); 

    $res_pega_cpf = $query_pega_cpf -> fetchAll(PDO::FETCH_ASSOC);

    //APROVA OU NAO O LOGIN COM BASE NA SAIDA DO BANCO
    $total_registros = count($res_pega_cpf);
    if ($total_registros == 1) {
        $status_usuario = $res_pega_cpf[0]["status_usuario"];
        $perfil = $res_pega_cpf[0]["perfil"];

        switch ($perfil) {
            case 'ADM':
                if ($status_usuario == 1) {
                    $_SESSION["cod_usuario"] = $res_pega_cpf[0]["cod_usuario"];
                    $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                    $_SESSION["logado"] = true;

                    $pega_dados_usuario = $pdo->query("SELECT nome, sobrenome, genero FROM adm WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                    $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC);
                    echo "<script>window.location = 'adm'</script>";
                } else {
                    echo "<script>window.alert('Usuário inativo. Contate o administrador.')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                    exit();
                }
                break;
            
            case 'Professor':
                if ($status_usuario == 1) {
                    $_SESSION["cod_usuario"] = $res_pega_cpf[0]["cod_usuario"];
                    $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                    $_SESSION["logado"] = true;

                    $pega_dados_usuario = $pdo->query("SELECT nome, sobrenome, genero FROM professor WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                    $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC); 
                    echo "<script>window.location = 'professor'</script>";
                } else {
                    echo "<script>window.alert('Usuário inativo. Contate o administrador.')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                    exit();
                }
                break;

            default:
                if ($status_usuario == 1) {
                    $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                    $_SESSION["logado"] = true;

                    $pega_dados_usuario = $pdo->query("SELECT nome, sobrenome genero FROM aluno WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                    $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC); 
                    echo "<script>window.location = 'aluno'</script>";
                } else {
                    echo "<script>window.alert('Usuário inativo. Contate o administrador.')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                    exit();
                }
                break;

        }
    } else {
        echo "<script>window.alert('Usuário ou senha incorretos! Tente novamente ou contate o administrador.')</script>";
        echo "<script>window.location = 'index.php'</script>";
        exit();
    }
    
?>