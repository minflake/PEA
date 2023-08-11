<?php
    @session_start();
    require_once("../../conexao.php");

    $atvd_a_enviar = $_GET;

    if (!empty($atvd_a_enviar)) {
        try {
            //MUDA O STATUS DE ENVIO E O STATUS DE AVALIACAO DAS ATIVDADES SELECIONADAS
            foreach ($_GET as $key => $value) {
                $query = $pdo->query("UPDATE atvd_feita SET status_envio = '1', status_avaliacao = '0',data_envio = current_timestamp() WHERE cod_atvd_feita = '$value';");
                $query = $query->fetchAll(PDO::FETCH_ASSOC);
                $cod_atvd_feita = $value;
            }

            //COSULTA O CÓDIGO DO RELATÓRIO DAS ATIVIDADES ENVIADAS
            $query = $pdo -> query("SELECT cod_relatorio FROM atvd_feita WHERE cod_atvd_feita = '$cod_atvd_feita';");
            $query =  $query -> fetchAll(PDO::FETCH_ASSOC);
            $cod_relatorio = $query[0]["cod_relatorio"];

            //CONSULTA AS HORAS VALIDAS E QUANTIDADE DE HORAS DAS ATIVIDADES ENVIADAS
            $query = $pdo->query("SELECT horas_validas, qntd_horas FROM atvd_feita WHERE cod_relatorio = '$cod_relatorio'
            AND status_envio = '1';");
            $atvd_enviada = $query->fetchAll(PDO::FETCH_ASSOC);

            //SOMA A QUANTIDADE DE HORAS E AS HORAS VÁLIDAS DAS ATIVIDADES ENVIADAS
            $horas_enviadas = 0;
            $horas_validas_enviadas = 0;
            foreach ($atvd_enviada as $key => $value) {
                $horas_validas_enviadas += $value["horas_validas"];
                $horas_enviadas += $value["qntd_horas"];
            }

            //ATUALIZA A QUANTIDADE DE HORAS ENVIADAS NO RELATÓRIO
            $query = $pdo -> query("UPDATE relatorio SET horas_enviadas = '$horas_enviadas' WHERE cod_relatorio = '$cod_relatorio';");
            $query = $query -> fetchAll(PDO::FETCH_ASSOC);

            //ATUALIZA O STATUS DE ENVIO DO RELATÓRIO SE TIVER MAIS DE 40 HORAS ENVIADAS
            if ($horas_enviadas >= 40) {
                $query = $pdo -> query("UPDATE relatorio SET status_envio = '1', data_envio = current_timestamp() WHERE cod_relatorio = '$cod_relatorio';");
                $query = $query -> fetchAll(PDO::FETCH_ASSOC);
            }
            
            //VERIFICA SE AS HORAS VÁLIDAS SOMAM MENOS DE 40
            if ($horas_validas_enviadas < 40) {
                $_SESSION['status_formulario'] = 'semi-true';
                header('Location: index.php');
            } else {
                $_SESSION['status_formulario'] = 'true';
                header('Location: index.php');
            }
        } catch (\Throwable $th) {
            throw $th;
            $_SESSION['status_formulario'] = false;
            //header('Location: enviar-atividades.php');
        }
    } else {
        echo "faz favor né";
        $_SESSION["status_formulario"] = 'selecionar_atvd';
        //header('Location: index.php');
    }

?>