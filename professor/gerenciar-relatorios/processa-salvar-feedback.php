<?php
    @session_start();
    require("../../conexao.php");
        
        $feedback = $_POST["feedback"];
        if (isset($_POST["descricao_feedback"])) {
            $descricao_feedback = $_POST["descricao_feedback"];
        } else {
            $descricao_feedback = null;
        }
        $cod_atvd_feita = $_POST["cod_atvd_feita"];

        try {
            $query = $pdo -> prepare("INSERT INTO feedback SET feedback = :feedback, descricao_feedback = :descricao_feedback, cod_atvd_feita = '$cod_atvd_feita', cod_professor = '" . $_SESSION["dados_usuario"][0]["cod_professor"] . "', data_criacao = current_timestamp();");

            $query -> bindValue(":feedback", $feedback);
            $query -> bindValue(":descricao_feedback", $descricao_feedback);
            $query -> execute();

            $query = $pdo -> query("UPDATE atvd_feita SET status_avaliacao = '1' WHERE cod_atvd_feita = '$cod_atvd_feita';");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);

            $_SESSION['status_formulario'] = true;
            header('Content-Type: application/json');
            echo json_encode($_SESSION['status_formulario']);
        } catch (\Throwable $th) {
            //throw $th;
            $_SESSION['status_formulario'] = false;
            header('Content-Type: application/json');
            echo json_encode($_SESSION['status_formulario']);
        }
    
?>