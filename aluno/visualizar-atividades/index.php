<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: ../../index.php");
    exit();
}

require_once("../../conexao.php");
$query = $pdo->query("SELECT atvd_feita.cod_atvd_feita, disciplina.nome_disc, atvd_a_fazer.tipo_atvd, atvd_feita.data_criacao, atvd_feita.qntd_horas, atvd_feita.horas_validas, atvd_feita.status_envio, atvd_feita.status_avaliacao, feedback.cod_feedback
    
    FROM atvd_feita
    LEFT JOIN disciplina ON atvd_feita.cod_disc = disciplina.cod_disc
    LEFT JOIN atvd_a_fazer ON atvd_feita.cod_atvd = atvd_a_fazer.cod_atvd
    LEFT JOIN feedback ON atvd_feita.cod_atvd_feita = feedback.cod_atvd_feita
    WHERE atvd_feita.cod_aluno ='" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "';");
$dados_atvd_feita = $query->fetchAll(PDO::FETCH_ASSOC);

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

            <div class="row gerenciar-alunos-nav justify-content-center">
                <div class="col-3">
                    <div class="card info-card sales-card">
                        <a href="enviar-atividades.php">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-richtext"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title">Enviar Atividades</h5>
                                    </div>
                                </div>

                                <div class="card-text">
                                    <p>
                                        Envie as atividades que foram registradas para avaliação.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card info-card sales-card">
                        <a href="enviar-atividades.php">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-richtext"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title">Extrair Relatório</h5>
                                    </div>
                                </div>

                                <div class="card-text">
                                    <p>
                                        Extraia um relatório de todas as atividades cadastradas.
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Atividades Registradas</h5>

                            <!-- Table with stripped rows -->
                            <table id="exemple" class="table datatable display nowrap" width="100%">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th class="datatable-collumn" scope="col">#</th>
                                        <th class="datatable-collumn" scope="col">Disciplina</th>
                                        <th class="datatable-collumn" scope="col">Tipo Atvd</th>
                                        <th class="datatable-collumn" scope="col">Data</th>
                                        <th class="datatable-collumn" scope="col">Enviada?</th>
                                        <th class="datatable-collumn" scope="col">Feedback</th>
                                        <th class="datatable-collumn" scope="col">Ações</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($dados_atvd_feita as $atvd_feita) {
                                    ?>
                                        <tr>
                                            <th scope='row'>
                                                <?php echo $atvd_feita["cod_atvd_feita"]; ?>
                                            </th>
                                            <td>
                                                <?php echo $atvd_feita["nome_disc"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $atvd_feita["tipo_atvd"]; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $formato_entrada = 'Y-m-d';
                                                $data_criacao = DateTime::createFromFormat($formato_entrada, $atvd_feita['data_criacao']);
                                                $data_criacao = $data_criacao->format('d/m/Y');
                                                echo $data_criacao;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($atvd_feita["status_envio"] == 0) {
                                                    echo "<span class='badge bg-warning text-dark'>Não enviada</span>";
                                                } else {
                                                    echo "<span class='badge bg-success'>Enviada</span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($atvd_feita["status_avaliacao"] == 1) {
                                                    echo "<span class='badge bg-success'>Recebido</span>";
                                                } else {
                                                    echo "<span class='badge bg-warning text-dark'>Não recebido</span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="row" style="width: 140px; margin: 0; padding: 8px;">
                                                    <?php
                                                    if (!isset($atvd_feita["cod_feedback"]) && $atvd_feita["status_envio"] == 0) {
                                                    ?>
                                                        <div class="div-datatable-collumn col-4">
                                                            <button class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="div-datatable-collumn col-4" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Aguarde o feedback para poder editar!">
                                                            <button class="btn btn-sm btn-outline-primary" disabled>
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="div-datatable-collumn col-4">
                                                        <form action="editar-atividade.php" method="get">
                                                            <input name="cod_atvd_feita" type="number" value="<?php echo $atvd_feita["cod_atvd_feita"]; ?>" hidden>
                                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                                <i class="bi bi-eye-fill"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <?php
                                                    if ($atvd_feita["status_envio"] == 0) {
                                                    ?>
                                                        <div class="div-datatable-collumn">
                                                            <button class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="div-datatable-collumn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Atividade já enviada, não é possível excluir!">
                                                            <button class="btn btn-sm btn-outline-danger" disabled>
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
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


    <script>
        /**
         * Initiate Datatables
         */
        const dataTableOptions = {
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            lengthMenu: [5, 10, 15, 20],
            columnDefs: [{
                    orderable: false,
                    targets: [6]
                },
                {
                    searchable: false,
                    targets: [2, 4, 5, 6]
                },
                {
                    width: "120px",
                    targets: [6]
                },
                {
                    width: "65px",
                    targets: [4, 5]
                }
            ],
            pageLength: 10,
            destroy: true,
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "Nenhum registro encontrado.",
                info: "Mostrando de _START_ a _END_ de um total de _TOTAL_ registros.",
                infoEmpty: "Nenhum registro encontrado.",
                infoFiltered: "(filtrados desde _MAX_ registros totais)",
                search: "Pesquisar:",
                loadingRecords: "Carregando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Próximo",
                    previous: "Anterior"
                }
            }
        };

        $(document).ready(function() {
            $('#exemple').DataTable(dataTableOptions);
        });
    </script>

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