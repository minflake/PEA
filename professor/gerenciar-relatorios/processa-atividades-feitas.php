<?php 
    @session_start();
    require("../../conexao.php");
    if (isset($_GET["cod_atvd_feita"])) {
        $cod_atvd_feita = $_GET["cod_atvd_feita"];

        $query = $pdo -> query("SELECT nome_arquivo, caminho_arquivo
        FROM arquivos
        LEFT JOIN atvd_feita ON arquivos.cod_arquivo = atvd_feita.cod_arquivo
        WHERE atvd_feita.cod_atvd_feita = '$cod_atvd_feita';");
        $query = $query -> fetchAll(PDO::FETCH_ASSOC);

        $caminho = $query[0]["caminho_arquivo"];   


        // Verifica se o arquivo existe
        if (file_exists($caminho)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $caminho .'"');
            header('Content-Length: ' . filesize($caminho));
            // Adicione o nome do arquivo ao cabeçalho
            header('X-Filename: ' . basename($caminho));
            readfile($caminho);
        }
    }



?>
