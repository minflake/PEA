<?php
@session_start();
require_once("conexao.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["filepond"])) {
    $foto_perfil = $_FILES["filepond"];

    // Diretório de destino onde o arquivo será salvo
    switch ($_SESSION["perfil"]) {
        case 'ADM':
            //$diretorio_destino = "C:/wamp64/www/PEA/arquivos/adm/foto-perfil/";
            $diretorio_destino = "/storage/ssd1/949/21117949/public_html/arquivos/adm/foto-perfil/";
            break;
        case 'Professor':
            //$diretorio_destino = "C:/wamp64/www/PEA/arquivos/professor/foto-perfil/";
            $diretorio_destino = "/storage/ssd1/949/21117949/public_html/arquivos/professor/foto-perfil/";
            break;

        default:
            //$diretorio_destino = "C:/wamp64/www/PEA/arquivos/aluno/foto-perfil/";
            $diretorio_destino = "/storage/ssd1/949/21117949/public_html/arquivos/aluno/foto-perfil/";
            break;
    }

    // Verifique se ocorreu algum erro durante o upload
    if ($foto_perfil["error"] > 0) {
        echo "Erro durante o upload do arquivo.";
        $_SESSION["status_formulario"] = "erro_envio";
        header('Location: primeiro-acesso-foto-perfil.php');
    }

    $extensoes_permitidas = array('jpg', 'jpeg', 'png');
    $extensao = strtolower(pathinfo($_FILES["filepond"]["name"], PATHINFO_EXTENSION));


    if (!in_array($extensao, $extensoes_permitidas)) {
        $_SESSION["status_formulario"] = "erro_extensao";
        echo "erro_extensao";
        header('Location: primeiro-acesso-foto-perfil.php');
    } else {
        // Obtenha informações sobre o arquivo enviado
        $nome_arquivo_tmp = $foto_perfil["name"];
        $caminho_temporario = $foto_perfil["tmp_name"];
        $tamanho_arquivo = $foto_perfil["size"];

        // Gere um nome único para evitar conflitos de nomes de arquivo
        $nome_arquivo = uniqid() . "_" . $nome_arquivo_tmp;

        // Mova o arquivo do diretório temporário para o diretório de destino
        if (move_uploaded_file($caminho_temporario, $diretorio_destino . $nome_arquivo)) {
            // O upload foi bem-sucedido, agora você pode salvar o caminho no banco de dados
            $caminho_completo = $diretorio_destino . $nome_arquivo;
        } else {
            $_SESSION["status_formulario"] = "erro_salvamento";
            header('Location: primeiro-acesso-foto-perfil.php');
            exit;
        }
    }

    try {
        $query = $pdo->prepare("INSERT INTO arquivos SET cod_usuario = '" . $_SESSION["cod_usuario"] . "', nome_arquivo_original = :nome_original, nome_arquivo = :nome_arquivo, extensao = :extensao, tamanho = :tamanho, caminho_arquivo = :caminho;");

        $query->bindValue(":nome_original", $nome_arquivo_tmp);
        $query->bindValue(":nome_arquivo", $nome_arquivo);
        $query->bindValue(":extensao", $foto_perfil["type"]);
        $query->bindValue(":tamanho", $tamanho_arquivo);
        $query->bindValue(":caminho", $caminho_completo);
        $query->execute();

        $query = $pdo->query("SELECT MAX(cod_arquivo) as cod_arquivo FROM arquivos;");
        $query = $query->fetchAll(PDO::FETCH_ASSOC);
        $cod_arquivo = $query[0]["cod_arquivo"];


        $query = $pdo->query("UPDATE usuario SET foto_perfil_cod_arquivo = '$cod_arquivo' WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
        $query = $query->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION["status_formulario"] = true;
        header('Location: primeiro-acesso-dados-usuario.php');
    } catch (\Throwable $th) {
        //throw $th;
        $_SESSION["status_formulario"] = "erro_salvamento";
        header('Location: primeiro-acesso-foto-perfil.php');
    }


    unset($_FILES["filepond"]);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["status_dados"])) {
    if ($_GET["status_dados"] == 1) {
        $_SESSION["status_formulario"] = 'dados_ok';
        header('Location: primeiro-acesso-genero-senha.php');
        unset($_GET["status_dados"]);
    } else {
        $_SESSION["status_formulario"] = 'dados_incorretos';
        header('Location: primeiro-acesso-genero-senha.php');
        unset($_GET["status_dados"]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["genero"]) && isset($_POST["senha"])) {
    $caracteres_senha = strlen($_POST["senha"]);
    if ($caracteres_senha < 8 || $caracteres_senha > 16) {
        $_SESSION["status_formulario"] = 'erro_senha';
        header('Location: primeiro-acesso-genero-senha.php');
        unset($_POST["senha"]);
        unset($_POST["genero"]);
    } else {
        try {
            $query = $pdo->prepare("UPDATE usuario SET senha = :senha WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
            $query->bindValue(":senha", $_POST["senha"]);
            $query->execute();

            if ($_SESSION["perfil"] == 'Aluno') {
                $query = $pdo->query("UPDATE aluno SET genero = '" . $_POST["genero"] . "' WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query_genero = $query -> fetchAll(PDO::FETCH_ASSOC);

                $query = $pdo -> query("SELECT genero FROM aluno WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query = $query -> fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["dados_usuario"][0]["genero"] = $query[0]["genero"];

            } elseif ($_SESSION["perfil"] == "Professor") {
                $query = $pdo->query("UPDATE professor SET genero = '" . $_POST["genero"] . "' WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query = $query->fetchAll(PDO::FETCH_ASSOC);

                $query = $pdo -> query("SELECT genero FROM professor WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query = $query -> fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["dados_usuario"][0]["genero"] = $query[0]["genero"];
            } else {
                $query = $pdo->query("UPDATE ADM SET genero = '" . $_POST["genero"] . "' WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query = $query->fetchAll(PDO::FETCH_ASSOC);

                $query = $pdo -> query("SELECT genero FROM adm WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "';");
                $query = $query -> fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["dados_usuario"][0]["genero"] = $query[0]["genero"];
            }

            
            $_SESSION["status_formulario"] = true;
            header('Location: primeiro-acesso-boas-vindas.php');
            unset($_POST["senha"]);
            unset($_POST["genero"]);
        } catch (\Throwable $th) {
            throw $th;
            $_SESSION["status_formulario"] = 'erro_salvar';
            header('Location: primeiro-acesso-genero-senha.php');
            unset($_POST["senha"]);
            unset($_POST["genero"]);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["primeiro_acesso"])) {
    if ($_GET["primeiro_acesso"] == 1) {
        $query = $pdo -> query("UPDATE usuario SET primeiro_acesso = '0' WHERE cod_usuario ='" . $_SESSION["cod_usuario"] . "';");
        $query = $query -> fetchAll(PDO::FETCH_ASSOC);

        if ($_SESSION["perfil"] == "Aluno") {
            header('Location: aluno/index.php');
        } elseif ($_SESSION["perfil"] == "Professor") {
            header('Location: professor/index.php');
        } else {
            header('Location: adm/index.php');
        }
        unset($_GET["primeiro_acesso"]);
    }
}
