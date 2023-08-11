<?php
@session_start();
require_once("conexao.php");

$query = $pdo->query("SELECT *, curso.nome_curso
    FROM aluno
    LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
    WHERE cod_usuario = '" . $_SESSION["cod_usuario"] . "'
;");
$dados_usuario = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primeiro Acesso</title>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet">

    <!-- FIlepond CSS Files -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="assets/img/6_250px/5.png">

</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="div-logo">
                        <img src="assets/img/6_250px/6.png" alt="">
                    </div>
                    <div class="d-none d-lg-block container-nome-ferramenta">
                        <div class="div-nome-ferramenta-1">
                            <span>PEA</span>
                        </div>
                        <div class="div-nome-ferramenta-2 align-items-bottom">
                            <span>Portal de Entrega de Atividades</span>
                        </div>
                    </div>
                </div>
            </a>
        </div><!-- End Logo -->
    </header>
    <main id="main" class="main" style="margin: 60px 0 0 0 !important; padding: 20px 30px !important;">

        <div class="pagetitle" style="text-align: center; height: 40px; vertical-align: middle !important;">
            <h1>Primeiros passos</h1>

        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row justify-content-center">

                <div class="col-md-8 col-xl-6">
                    <div class="card">
                        <div class="card-body pt-3 justify-content-center">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered justify-content-center">

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" disabled>Foto de Perfil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Seus dados</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" disabled>Mudar Senha</button>
                                </li>

                            </ul>

                            <?php
                            if ($_SESSION["perfil"] == "Aluno") {
                            ?>
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Por favor, confira seus dados.</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Nome</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["nome"] . " " . $dados_usuario[0]["sobrenome"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">RA</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["ra"] ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">CPF</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["cpf"] ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Data de Nascimento</div>
                                        <div class="col-lg-9 col-md-8">
                                            <?php
                                            $formato_banco = "Y-m-d";
                                            $data_nascimento = DateTime::createFromFormat($formato_banco, $dados_usuario[0]['data_nascimento']);
                                            $data_nascimento = $data_nascimento->format('d/m/Y');
                                            echo $data_nascimento;
                                            ?>


                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Curso</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["nome_curso"] ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Semestre</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["semestre"] . "º Semestre" ?></div>
                                    </div>



                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $dados_usuario[0]["email"] ?></div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <form class="col-md-6" action="processa-primeiro-acesso.php" method="get">
                                            <input type="number" value="0" name="status_dados" hidden>
                                            <div class="d-grid gap-2 mt-3">
                                                <button class="btn btn-danger" type="submit">Dados incorretos.</button>
                                            </div>
                                        </form>

                                        <form class="col-md-6" action="processa-primeiro-acesso.php" method="get">
                                            <input type="number" value="1" name="status_dados" hidden>
                                            <div class="d-grid gap-2 mt-3">
                                                <button class="btn btn-primary" type="submit">Tudo certo!</button>
                                            </div>
                                        </form>
                                    </div>



                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- ALERTAS -->
<?php
        if (isset($_SESSION['status_formulario'])) {
            switch ($_SESSION['status_formulario']) {
                case true:
        ?>
                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center alerts-settings">
                            <div class="alert alert-success alert-dismissible fade show " role="alert">
                                Foto salva com sucesso!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['status_formulario']);
                    break;
                default:
                ?>

                    <div class="row justify-content-center">
                        <div class="col-12 d-flex justify-content-center alerts-settings">
                            <div class="alert alert-danger alert-dismissible fade show " role="alert">
                                Erro ao salvar o arquivo. Contate o administrador.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['status_formulario']);
                    break;
                ?>
        <?php
            }
        }
        ?>

    </main><!-- End #main -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Filepond vendor JS files -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
    <script src="assets/js/filepond-locale-pt-br.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>


    <script>
        // We register the plugins required to do 
        // image previews, cropping, resizing, etc.
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginImageEdit
        );

        // Select the file input and use 
        // create() to turn it into a pond
        const input = document.querySelector('input[type="file"]');
        FilePond.create(input, {
            storeAsFile: true,
            labelIdle: 'Arraste e solte sua imagem ou <span class="filepond--label-action">Navegue</span>',
            imagePreviewHeight: 170,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,
            stylePanelLayout: 'compact circle',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',

        });
    </script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>


</body>

</html>