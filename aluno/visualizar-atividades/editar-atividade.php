<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: ../../index.php");
    exit();
}

require_once("../../conexao.php");

if (isset($_GET["cod_atvd_feita"])) {
    $cod_atvd_feita = $_GET["cod_atvd_feita"];

    //CONSULTA OS DADOS DA ATIVIDADE FEITA
    $query = $pdo->query("SELECT atvd_a_fazer.cod_atvd, atvd_a_fazer.tipo_atvd, atvd_feita.qntd_horas, atvd_feita.data_atvd, atvd_feita.descricao_atvd, disciplina.cod_disc, disciplina.nome_disc, arquivos.caminho_arquivo, arquivos.cod_arquivo, atvd_feita.status_avaliacao

    FROM atvd_feita
    LEFT JOIN atvd_a_fazer ON atvd_feita.cod_atvd = atvd_a_fazer.cod_atvd
    LEFT JOIN disciplina ON atvd_feita.cod_disc = disciplina.cod_disc
    LEFT JOIN arquivos ON atvd_feita.cod_arquivo = arquivos.cod_arquivo
    WHERE atvd_feita.cod_atvd_feita = '$cod_atvd_feita';");
    $dados_atvd_feita = $query->fetchAll(PDO::FETCH_ASSOC);

    //CONSULTA OS FEEDBACKS DA ATIVIDADE FEITA
    $query = $pdo->query("SELECT feedback.cod_feedback, feedback.feedback, feedback.descricao_feedback, feedback.data_criacao, professor.nome, professor.sobrenome
    FROM feedback
    LEFT JOIN professor ON feedback.cod_professor = professor.cod_professor
    WHERE feedback.cod_atvd_feita = '$cod_atvd_feita';");
    $dados_feedback = $query->fetchAll(PDO::FETCH_ASSOC);

    //CONSULTAR NO BANCO DE DADOS EM QUAIS DISCIPLINAS O ALUNO ESTÁ MATRICULADO
    $query = $pdo->query("SELECT * FROM disc_matriculada WHERE cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "'" . "AND status_matricula != '0'");
    $disc_matriculada = $query->fetchAll(PDO::FETCH_ASSOC);

    //CONSULTAR NO BANCO AS ATIVIDADES QUE O ALUNO PODE FAZER COM BASE NO SEU CURSO E NO STATUS DE ARQUIVAMENTO
    $query = $pdo->query("SELECT atvd_por_curso.cod_atvd, atvd_a_fazer.tipo_atvd, atvd_a_fazer.descricao_atvd, atvd_por_curso.carga_horaria_max, atvd_por_curso.limite_horas_atvd, atvd_a_fazer.categoria_atvd, atvd_a_fazer.tipo_doc_comprobatorio, atvd_por_curso.status_arquivamento

    FROM atvd_por_curso
    LEFT JOIN atvd_a_fazer ON atvd_por_curso.cod_atvd = atvd_a_fazer.cod_atvd
    WHERE cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "' AND status_arquivamento = '0';
    ");
    $dados_atvd_a_fazer = $query->fetchAll(PDO::FETCH_ASSOC);
}




?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Visualizar Atividades</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../assets/img/6_250px/5.png" rel="icon">
    <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../../assets/css/style.css" rel="stylesheet">

    <!-- DataTable files -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="../index.php" class="logo d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="div-logo">
                        <img src="../../assets/img/6_250px/6.png" alt="">
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
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill" style="display: inline-block; font-size: 25px; opacity: 1; -webkit-text-stroke: 0.5px rgb(255, 255, 255); color: rgb(13, 109, 141);"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?php
                            @session_start();
                            echo $_SESSION["dados_usuario"][0]["nome"];
                            ?>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>
                                <?php
                                @session_start();
                                echo $_SESSION["dados_usuario"][0]["nome"];
                                echo " {$_SESSION["dados_usuario"][0]["sobrenome"]}";
                                ?>
                            </h6>
                            <span>Aluno</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                                <i class="bi bi-person"></i>
                                <span>Meu Perfil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                                <i class="bi bi-gear"></i>
                                <span>Configurações da Conta</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.php">
                                <i class="bi bi-question-circle"></i>
                                <span>Precisa de ajuda?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="../../logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sair</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading">Ferramentas</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="../index.php">
                    <i class="ri ri-home-2-line"></i>
                    <span>Home</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="../acessar-regulamento/index.php">
                    <i class="ri ri-file-paper-2-line"></i>
                    <span>Acessar Regulamento</span>
                </a>
            </li><!-- End Blank Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="../registrar-atividades/index.php">
                    <i class="bi bi-file-earmark-richtext"></i>
                    <span>Registrar Atividades</span>
                </a>
            </li><!-- End Blank Page Nav -->

            <li class="nav-item">
                <a class="nav-link" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-list-check"></i><span>Atividades Registradas</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="index.php" class="active">
                            <i class="bi bi-circle"></i><span>Visualizar Atividades</span>
                        </a>
                    </li>
                    <li>
                        <a href="enviar-atividades.php">
                            <i class="bi bi-circle"></i><span>Enviar Atividades</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Importar Alunos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Extrair Relatório</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Forms Nav -->

            <li class="nav-heading">Utilitários</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-person"></i>
                    <span>Perfil</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-question-circle"></i>
                    <span>Suporte</span>
                </a>
            </li><!-- End F.A.Q Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="../../logout.php ">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Sair</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Visualizar Atividades</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>

                    <li class="breadcrumb-item active">Visualizar Atividades</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Atividades Registradas</h5>


                            <!-- Floating Labels Form -->
                            <form class="row g-3 needs-validation" action="processa-editar-atividade.php" method="post" enctype="multipart/form-data" novalidate>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="tipoAtvd" name="tipo_atvd" required>
                                            <option value="" disabled>Selecione o Tipo da Atividade</option>
                                            <?php
                                            foreach ($dados_atvd_a_fazer as $key => $atvd_a_fazer) {
                                                $selected = ($atvd_a_fazer["cod_atvd"] == $dados_atvd_feita[0]["cod_atvd"]) ? 'selected' : '';
                                                echo "<option value='" . $atvd_a_fazer["cod_atvd"] . "' $selected>" . $atvd_a_fazer["tipo_atvd"] . "</option>";
                                            }

                                            ?>
                                        </select>
                                        <label for="tipoAtvd">Tipo de Atividade</label>
                                        <div class="invalid-feedback">
                                            Selecione o Tipo de Atividade.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="selectQtndHoras" name="qntd_horas" required>
                                            <option value="" selected disabled>Selecione as Horas</option>
                                            <?php
                                            for ($j = 1; $j <= 40; $j++) {
                                                $selected = ($j == $dados_atvd_feita[0]["qntd_horas"]) ? 'selected' : '';
                                                echo "<option value='$j' $selected>$j</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="selectCargaMax">Qantidade de Horas</label>
                                        <div class="invalid-feedback">
                                            Informe a quantidade de horas.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="dataAtvd" name="data_atvd" placeholder="Data da Atividade" value="<?php echo $dados_atvd_feita[0]["data_atvd"]; ?>" required>
                                        <label for="dataAtvd">Data de Realização da Atividade</label>
                                        <div class="invalid-feedback">
                                            Informe a data.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="" id="floatingDescricaoAtividade" style="height: 132px;" name="descricao_atvd" required><?php echo $dados_atvd_feita[0]["descricao_atvd"]; ?></textarea>
                                        <label for="floatingPassword">Descrição da Atividade</label>
                                        <div class="invalid-feedback">
                                            Insira a descrição da atividade.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-control">
                                        <label for="anexo" class="col-md-12 col-form-label">Envie um Comprovante</label>
                                        <div class="col-md-12">
                                            <input class="form-control" type="file" id="anexo" name="anexo" accept=".jpg, .jpeg, .png, .pdf" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            Insira um anexo.
                                        </div>
                                        <div class="form-input-description">
                                            Extensões aceitas: <span class="form-file-format">.jpg, .jpeg, .png e .pdf.</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="selectDisciplina" name="disciplina" required>
                                            <option value="" disabled>Selecione a Disciplina</option>
                                            <option value="<?php echo $dados_atvd_feita[0]["cod_disc"] ?>" selected><?php echo $dados_atvd_feita[0]["nome_disc"] ?></option>
                                        </select>
                                        <label for="selectCargaMax">Disciplina</label>
                                        <div class="invalid-feedback">
                                            Informe a disciplina.
                                        </div>
                                    </div>
                                </div>
                                <input name="caminho_arquivo" type="text" value="<?php echo $dados_atvd_feita[0]["caminho_arquivo"]; ?>" hidden>
                                <input name="cod_arquivo" type="number" value="<?php echo $dados_atvd_feita[0]["cod_arquivo"]; ?>" hidden>
                                <input name="cod_atvd_feita" type="number" value="<?php echo $cod_atvd_feita; ?>" hidden>
                                <div class=" row justify-content-center text-center">
                                    <?php
                                    if ($dados_atvd_feita[0]["status_avaliacao"] == 1) {
                                        $linhas_dados_feedback = count($dados_feedback);
                                        if (!empty($dados_feedback) && $dados_feedback[$linhas_dados_feedback - 1]["feedback"] == 0) {

                                    ?>
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Atividade já aprovada, não é possível editar.">
                                                <button type="submit" class="btn btn-primary" disabled>Salvar alterações</button>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>

                                        <div class="col-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Aguarde o feedback para poder editar a atividade.">
                                            <button type="submit" class="btn btn-primary" disabled>Salvar alterações</button>
                                        </div>

                                    <?php
                                    }
                                    ?>


                                </div>
                            </form><!-- End floating Labels Form -->



                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Feedback</h5>

                            <?php
                            if (!empty($dados_feedback)) {
                            ?>

                                <!-- Default Accordion -->
                                <div class="accordion" id="accordionExample">
                                    <?php
                                    foreach ($dados_feedback as $key => $value) {
                                        //TRATA E CONVERTE A ENTRADA "INICIO DAS ENTREGAS" PARA STRING
                                        $formato_banco = "Y-m-d H:i:s";
                                        $data_criacao = DateTime::createFromFormat($formato_banco, $value['data_criacao']);
                                        $data_criacao = $data_criacao->format('d/m/Y - H:i:s');
                                    ?>

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $key; ?>" aria-expanded="false" aria-controls="collapse<?php echo $key; ?>">
                                                    Feedback <?php echo $key + 1 . " - " . $data_criacao; ?>
                                                </button>
                                            </h2>
                                            <div id="collapse<?php echo $key; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $key; ?>" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <strong>Feedback por: </strong><?php echo $value["nome"] . " " . $value["sobrenome"]; ?><br>
                                                    <strong>Status: </strong>

                                                    <?php
                                                    if ($value["feedback"] == 1) {
                                                        echo "<span class='badge bg-success'>Aprovada</span>";
                                                    } else {
                                                        echo "<span class='badge bg-danger'>Reprovada</span>";
                                                    }
                                                    ?>
                                                    <br><br>
                                                    <?php echo $value["descricao_feedback"]; ?>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                </div><!-- End Default Accordion Example -->

                            <?php
                            } else {
                                echo "Nenhum feedback dado. Envie a atividade e aguarde a devolutiva de seu professor.";
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
            <!-- ALERTAS -->
            <?php
            if (isset($_SESSION['status_formulario'])) {
                switch ($_SESSION['status_formulario']) {
                    case 'true':
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div class="alert alert-success alert-dismissible fade show " role="alert">';
                        echo 'Atividades enviadas com sucesso!';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        unset($_SESSION['status_formulario']);
                        break;
                    case false:
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div class="alert alert-danger alert-dismissible fade show " role="alert">';
                        echo 'Erro ao enviar atividades, contate o administrador!';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        unset($_SESSION['status_formulario']);
                        break;
                    default:
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div style="text-align: center;" class="alert alert-warning alert-dismissible fade show " role="alert">';
                        echo 'Atenção, você tem mens de 40 horas válidas enviadas.<br>
                        Sujeito a reprovação.';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="row justify-content-center">';
                        echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div style="text-align:center;" class="alert alert-success alert-dismissible fade show " role="alert">';
                        echo 'Atividades enviadas com sucesso!';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        unset($_SESSION['status_formulario']);
                        break;
                }
            }
            ?>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../../assets/vendor/quill/quill.min.js"></script>
    <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../../assets/js/main.js"></script>

</body>

</html>