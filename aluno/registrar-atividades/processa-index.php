<?php
require_once("../../conexao.php");
@session_start();

$tipo_atvd = $_POST["tipo_atvd"];
$qntd_horas = $_POST["qntd_horas"];
$data_atvd = $_POST["data_atvd"];
$descricao_atvd = $_POST["descricao_atvd"];
$anexo = $_FILES["anexo"];
$disciplina = $_POST["disciplina"];

var_dump($anexo);

// Verifique se o formulário foi enviado corretamente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["anexo"])) {
    // Diretório de destino onde o arquivo será salvo
    $diretorio_destino = "C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/";

    // Verifique se ocorreu algum erro durante o upload
    if ($anexo["error"] > 0) {
        echo "Erro durante o upload do arquivo.";
    }

    $extensoes_permitidas = array('pdf', 'jpg', 'jpeg', 'png');
    $extensao = strtolower(pathinfo($_FILES["anexo"]["name"], PATHINFO_EXTENSION));


    if (!in_array($extensao, $extensoes_permitidas)) {
        $_SESSION['status_formulario'] = "erro_extensao";
        header('Location: index.php');
    } else {
        // Obtenha informações sobre o arquivo enviado
        $nome_arquivo_tmp = $anexo["name"];
        $caminho_temporario = $anexo["tmp_name"];
        $tamanho_arquivo = $anexo["size"];

        // Gere um nome único para evitar conflitos de nomes de arquivo
        $nome_arquivo = uniqid() . "_" . $nome_arquivo_tmp;

        // Mova o arquivo do diretório temporário para o diretório de destino
        if (move_uploaded_file($caminho_temporario, $diretorio_destino . $nome_arquivo)) {
            // O upload foi bem-sucedido, agora você pode salvar o caminho no banco de dados
            $caminho_completo = $diretorio_destino . $nome_arquivo;
            echo "salvo em $caminho_completo";

            try {
                //GUARDA O ANEXO CRIANDO UMA NOVA LINHA NA TABELA ARQUIVOS
                $query = $pdo->prepare("INSERT INTO arquivos SET cod_usuario = '" . $_SESSION["cod_usuario"] . "', nome_arquivo_original = :nome_arquivo_original, nome_arquivo = '$nome_arquivo', tipo = '" . $anexo["type"] . "', tamanho = '" . $anexo["size"] . "',caminho_arquivo = '$caminho_completo';");
                $query->bindValue(":nome_arquivo_original", $nome_arquivo_tmp);
                $query->execute();

                //PEGA O CÓDIGO DO ÚLTIMO ANEXO INSERIDO
                $query = $pdo->query("SELECT MAX(arquivos.cod_arquivo) AS cod_arquivo FROM arquivos;");
                $query = $query->fetchAll(PDO::FETCH_ASSOC);
                $cod_arquivo = $query[0]["cod_arquivo"];

                //CONSULTA SE O ALUNO LOGADO JÁ TEM UM RELATÓRIO PARA A DISCIPLINA SELECIONADA
                $query = $pdo->query("SELECT cod_relatorio FROM relatorio WHERE cod_disc = '$disciplina' AND cod_aluno ='" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "';");
                $query = $query->fetchAll(PDO::FETCH_ASSOC);
                $cod_relatorio = $query[0]["cod_relatorio"];

                //VERIFICA SE A CONSULTA RETORNOU UM RELATÓRIO
                if (empty($query)) {
                    //CRIA UM RELATÓRIO CASO NÃO EXISTA E ARMAZENA O CÓDIGO DO RELATÓRIO 
                    $query = $pdo->query("INSERT INTO relatorio SET cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "', cod_disc = '" . $disciplina . "';");
                    $query = $query->fetchAll(PDO::FETCH_ASSOC);

                    $query = $pdo->query("SELECT MAX(relatorio.cod_relatorio) AS cod_relatorio FROM relatorio;");
                    $query = $query->fetchAll(PDO::FETCH_ASSOC);
                    $cod_relatorio = $query[0]["cod_relatorio"];
                }

                //CONSULTA TODAS AS ATIVIDADES FEITAS DO ALUNO E SOMA AS HORAS VÁLIDAS
                $query = $pdo -> query("SELECT atvd_feita.horas_validas, atvd_por_curso.carga_horaria_max 
                FROM atvd_feita
                LEFT JOIN atvd_por_curso ON atvd_feita.cod_atvd = atvd_por_curso.cod_atvd
                WHERE atvd_feita.cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "' AND
                atvd_feita.cod_disc = '$disciplina' AND atvd_por_curso.cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "';");
                $todas_atvds = $query -> fetchAll(PDO::FETCH_ASSOC);
                
                //VERIFICA SE A CONSULTA RETORNOU UM REGISTRO
                if (!empty($todas_atvds)) {
                    $total_horas_validas = 0;
                    foreach ($todas_atvds as $key => $value) {
                        $total_horas_validas += $value["horas_validas"];
                    }

                    //VERIFICA SE O TOTAL DE HORAS VÁLIDAS É MAIOR DO QUE 40
                    if ($total_horas_validas >= 40) {
                        $horas_validas = 0;
                    } else {
                        //CONSULTA AS ATIVIDADES FEITAS DO ALUNO DO TIPO ATUAL E SOMA AS HORAS VÁLIDAS
                        $query = $pdo -> query("SELECT horas_validas, atvd_por_curso.carga_horaria_max 
                        FROM atvd_feita
                        LEFT JOIN atvd_por_curso ON atvd_feita.cod_atvd = atvd_por_curso.cod_atvd
                        WHERE atvd_feita.cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "' AND
                        atvd_feita.cod_disc = '$disciplina' AND atvd_por_curso.cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "'
                        AND atvd_feita.cod_atvd = '$tipo_atvd';");
                        $carga_max_atvd = $query -> fetchAll(PDO::FETCH_ASSOC);

                        //VERIFICA SE A CONSULTA RETORNOU UM REGISTRO
                        if (!empty($carga_max_atvd)) {
                            $total_horas_validas = 0;
                            foreach ($carga_max_atvd as $key => $value) {
                                $total_horas_validas += $value["horas_validas"];           
                            }

                            //VERIFICA SE O TOTAL DE HORAS VÁLIDAS DO TIPO DE ATIVIDADE ATUAL É MAIOR DO QUE 40
                            if ($total_horas_validas >= $carga_max_atvd[0]["carga_horaria_max"]) {
                                $horas_validas = 0;
                            } else {
                                //CONSULTA O LIMITE DE HORAS POR ATIVIDADE E A CARGA MAXIMA DA ATIVIDADE ATUAL
                                $query = $pdo -> query("SELECT atvd_por_curso.limite_horas_atvd, atvd_por_curso.carga_horaria_max 
                                FROM atvd_por_curso
                                WHERE cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "' AND
                                cod_atvd = '$tipo_atvd';");
                                $dados_horas_atvd = $query -> fetchAll(PDO::FETCH_ASSOC);

                                //VERIFICA SE A CONSULTA RETORNOU UM REGISTRO
                                if (!empty($dados_horas_atvd)) {
                                    if ($qntd_horas > $dados_horas_atvd[0]["limite_horas_atvd"]) {
                                        $horas_validas = $dados_horas_atvd[0]["limite_horas_atvd"];
                                    } else {
                                        $horas_validas = $qntd_horas;
                                    }
                                } else {
                                    $horas_validas = $qntd_horas;
                                }
                            }
                        } else {
                            $horas_validas = $qntd_horas;
                        }
                    }
                } else {
                    $horas_validas = $qntd_horas;
                }
                //GUARDA OS DADOS RESTANTES NA TABELA ATVD_FEITA
                $query = $pdo->prepare("INSERT INTO atvd_feita SET cod_atvd = :cod_atvd, cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "', cod_disc = :cod_disc, cod_arquivo = '$cod_arquivo', cod_relatorio = '$cod_relatorio', descricao_atvd = :descricao_atvd, data_atvd = :data_atvd, qntd_horas = :qntd_horas, horas_validas = $horas_validas");
                $query->bindValue(":cod_atvd", $tipo_atvd);
                $query->bindValue(":cod_disc", $disciplina);
                $query->bindValue(":descricao_atvd", $descricao_atvd);
                $query->bindValue(":data_atvd", $data_atvd);
                $query->bindValue(":qntd_horas", $qntd_horas);
                $query->execute();

                $_SESSION['status_formulario'] = 'true';
                header('Location: index.php');
            } catch (\Throwable $th) {
                //throw $th;
                $_SESSION['status_formulario'] = false;
                header('Location: index.php');
            }
        }
    }
} else {
    echo "arruma esse form bichao";
}
