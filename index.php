<?php
    // Verificar se o usuário está logado e fazer redirecionamento para o perfil correto
    session_start();
    if (isset($_SESSION["logado"])) {
        if ($_SESSION["logado"] == true) {
            switch ($_SESSION["perfil"]) {
                case 'Professor':
                    header("Location: professor/index.php");
                    break;
                
                case 'Adm':
                    header("Location: adm/index.php");
                    break;
                default:
                    header("Location: aluno/index.php");
                    break;
            }
        }
    }

    //CONECTA AO BANCO DE DADOS
    require_once("conexao.php");

    //DEFINE USUÁRIO E SENHA PARA O ADM
    $senha = '1234';
    $cpf = 52456000803;

    //VERIFICAR SE ADM JÁ EXISTE NO BANCO
    $verificar_adm = $pdo -> query("SELECT * from usuario WHERE perfil = 'ADM'");
    $res_verificar_adm = $verificar_adm -> fetchAll(PDO::FETCH_ASSOC);

    //CRIAR USUARIO ADM CASO NAO EXISTA
    if ($contar_registros_adm = count($res_verificar_adm) == 0) {$novo_adm = $pdo -> query("INSERT INTO usuario SET senha = '$senha', status_usuario = '1', perfil = 'ADM'");
        var_dump($novo_adm);
        if ($novo_adm) {
            $pega_cod_usuario = $pdo -> lastInsertId();
            var_dump($pega_cod_usuario);
            $pdo -> query("UPDATE adm 
                SET cpf = '$cpf'
                WHERE cod_usuario = $pega_cod_usuario;
            ");
        }
    }
    
    

?>      

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEA - Login</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="assets/img/6_250px/5.png">

</head>
<body>
    <div class="container login-container">
        <div class="row">
            <div class="col-md-6 ads">
                <h1><span id="fl">PEA</span><br></h1>

                <div class="logo-img">
                    <img src="assets/img/6_1000px/3.png" alt="logo_img">
                </div>
            </div>
            <div class="col-md-6 login-form">
                <div class="profile-img">
                    <img src="assets/img/6_250px-non-transparent/2.png" alt="profile_img" height="140px" width="140px;">
                </div>

                <h3>Faça seu login</h3>
            
                <form action="login.php" method="post">
                    <div class="form-group">
                        <input type="text" pattern="\d{11}" title="Digite um CPF válido" class="form-control" name="cpf" placeholder="CPF apenas números" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="senha" placeholder="Senha">
                    </div>
                    <div class="form-group-btn">
                        <button type="submit" class="btn-login">Entrar</button>
                    </div>
                    <br>
                    <div class="form-group forget-password">
                        <a href="#">Esqueci a senha</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>