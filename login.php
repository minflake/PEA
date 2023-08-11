<?php 
    //INICIAR CONEXAO COM O BANCO DE DADOS
    require_once ("conexao.php");

    //INCIAR SESSÃO
    @session_start();

    //RECEBE OS DADOS ENTRADOS PELO FORMULARIO DE LOGIN NO INDEX
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    $padraoData = '/^\d{2}\/\d{2}\/\d{4}$/';
    $formato_entrada = "d/m/Y";

    if (preg_match($padraoData, $senha)) {
        $data_convertida = DateTime::createFromFormat($formato_entrada, $senha);
        $senha = $data_convertida -> format('Y-m-d');
    }

        //CONSULTA E VERIFICA SE OS DADOS INSERIDOS EXISEM NO BANCO
        $query_pega_cpf = $pdo -> prepare ("SELECT usuario.cod_usuario, usuario.senha, usuario.perfil, usuario.status_usuario, usuario.primeiro_acesso,
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
            $primeiro_acesso =$res_pega_cpf[0]["primeiro_acesso"];
            $perfil = $res_pega_cpf[0]["perfil"];

            switch ($perfil) {
                case 'ADM':
                    if ($status_usuario == 1) {
                        $_SESSION["cod_usuario"] = $res_pega_cpf[0]["cod_usuario"];
                        $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                        $_SESSION["logado"] = true;

                        $pega_dados_usuario = $pdo->query("SELECT cod_adm, nome, sobrenome, genero FROM adm WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                        $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC);

                        if ($primeiro_acesso == 1) {
                            header('Location: primeiro-acesso-foto-perfil.php');
                        } else {
                            header('Location: adm/index.php');
                        }
                    } else {
                        $_SESSION["status_formulario"] = true;
                        header('Location: index.php');
                        exit();
                    }
                    break;
                
                case 'Professor':
                    if ($status_usuario == 1) {
                        $_SESSION["cod_usuario"] = $res_pega_cpf[0]["cod_usuario"];
                        $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                        $_SESSION["logado"] = true;

                        $pega_dados_usuario = $pdo->query("SELECT cod_professor, cod_curso, nome, sobrenome, genero FROM professor WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                        $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC); 
                        if ($primeiro_acesso == 1) {
                            header('Location: primeiro-acesso-foto-perfil.php');
                        } else {
                            header('Location: professor/index.php');
                        }
                    } else {
                        $_SESSION["status_formulario"] = true;
                        header('Location: index.php');
                        exit();
                    }
                    break;

                default:
                    if ($status_usuario == 1) {
                        $_SESSION["cod_usuario"] = $res_pega_cpf[0]["cod_usuario"];
                        $_SESSION["perfil"] = $res_pega_cpf[0]["perfil"];
                        $_SESSION["logado"] = true;

                        $pega_dados_usuario = $pdo->query("SELECT cod_aluno, cod_curso, nome, sobrenome, genero, semestre FROM aluno WHERE cod_usuario = '{$_SESSION["cod_usuario"]}'");
                        $_SESSION["dados_usuario"] = $pega_dados_usuario -> fetchAll(PDO::FETCH_ASSOC); 
                        
                        if ($primeiro_acesso == 1) {
                            header('Location: primeiro-acesso-foto-perfil.php');
                        } else {
                            header('Location: aluno/index.php');
                        }
                    } else {
                        $_SESSION["status_formulario"] = true;
                        header('Location: index.php');
                        exit();
                    }
                    break;

            }
        } else {
            $_SESSION["status_formulario"] = false;
            header('Location: index.php');
            exit();
        }

    
    
?>