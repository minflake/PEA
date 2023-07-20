<?php 
//SOLICITA A CONEXAO COM O BANCO
require_once("../../conexao.php");
session_start();
//ATRIBUI AS ENTRADAS DO FORMULARIO A VARIAVEIS
$nome = $_POST["nome"];
$sobrenome = $_POST["sobrenome"];
$dia = $_POST["dia"];
$mes = $_POST["mes"];
$ano = $_POST["ano"];
$cpf = $_POST["cpf"];
$ra = $_POST["ra"];
$email = $_POST["email"];
$curso = $_POST["curso"];
$semestre = $_POST["semestre"];
if (isset($_POST["TAA001"])) {
    // O checkbox foi marcado
    $TAA001 = 1;

  } else {
    // O checkbox não foi marcado
    $TAA001 = null;
}
if (isset($_POST["TAA002"])) {
    // O checkbox foi marcado
    $TAA002 = 2;
  } else {
    // O checkbox não foi marcado
    $TAA002 = null; 
}

//TRATAMENTO DA DATA DE NASCIMENTO
$formato_entrada = "d/m/Y";
$data_nascimento = $dia . "/$mes/" . $ano;
$data_nascimento_convertido = DateTime::createFromFormat($formato_entrada, $data_nascimento);
$data_nascimento_formatado = $data_nascimento_convertido -> format('Y-m-d');

//TRATAMENTO DO CPF
$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);

//GUARDA AS ENTRADAS NO BANCO
try {
    $query_guarda_tabela_aluno = $pdo -> prepare("INSERT INTO aluno SET nome = :nome, sobrenome = :sobrenome, data_nascimento = :data_nascimento, cpf = :cpf, ra = :ra, email = :email, semestre = :semestre");

    $query_guarda_tabela_aluno -> bindValue(":nome", "$nome");
    $query_guarda_tabela_aluno -> bindValue(":sobrenome", "$sobrenome");
    $query_guarda_tabela_aluno -> bindValue(":data_nascimento", "$data_nascimento_formatado");
    $query_guarda_tabela_aluno -> bindValue(":cpf", "$cpf");
    $query_guarda_tabela_aluno -> bindValue(":ra", "$ra");
    $query_guarda_tabela_aluno -> bindValue(":email", "$email");
    $query_guarda_tabela_aluno -> bindValue(":semestre", "$semestre");
    $query_guarda_tabela_aluno -> execute();

    $query_pega_cod_aluno = $pdo-> query("SELECT MAX(aluno.cod_aluno) AS cod_aluno FROM aluno");
    $query_pega_cod_aluno = $query_pega_cod_aluno -> fetchAll(PDO::FETCH_ASSOC);
    $cod_aluno = $query_pega_cod_aluno[0]['cod_aluno'];
    
    if ($TAA001 == 1) {
        $query_disc_matriculada = $pdo -> prepare("INSERT INTO disc_matriculada SET cod_disc = :cod_disc, cod_aluno = :cod_aluno, status_matricula = '1'");

        $query_disc_matriculada -> bindValue(":cod_disc", "$TAA001");
        $query_disc_matriculada -> bindValue(":cod_aluno", "$cod_aluno");
        $query_disc_matriculada -> execute();
    
    } else {
        $query_disc_matriculada = $pdo -> prepare("INSERT INTO disc_matriculada SET cod_disc = '1', cod_aluno = :cod_aluno, status_matricula = '0'");

        $query_disc_matriculada -> bindValue(":cod_aluno", "$cod_aluno");
        $query_disc_matriculada -> execute();
    }

    if ($TAA002 == "2") {
        $query_disc_matriculada = $pdo -> prepare("INSERT INTO disc_matriculada SET cod_disc = :cod_disc, cod_aluno = :cod_aluno, status_matricula = '1'");

        $query_disc_matriculada -> bindValue(":cod_disc", "$TAA002");
        $query_disc_matriculada -> bindValue(":cod_aluno", "$cod_aluno");
        $query_disc_matriculada -> execute();
    } else {
        $query_disc_matriculada = $pdo -> prepare("INSERT INTO disc_matriculada SET cod_disc = '2', cod_aluno = :cod_aluno, status_matricula = '0'");

        $query_disc_matriculada -> bindValue(":cod_aluno", "$cod_aluno");
        $query_disc_matriculada -> execute();
    }


    $_SESSION['status_formulario'] = true;
    header('Location: cadastrar-alunos.php');

} catch (\Throwable $th) {
    $_SESSION['status_formulario'] = false;
    header('Location: cadastrar-alunos.php');
}



?>