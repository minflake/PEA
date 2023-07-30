<?php
session_start();
// Verificar se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: ../../index.php");
    exit();
}
//CONSULTAR NO BANCO DE DADOS EM QUAIS DISCIPLINAS O ALUNO ESTÁ MATRICULADO
require_once("../../conexao.php");
$query = $pdo->query("SELECT * FROM disc_matriculada WHERE cod_aluno = '" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "'" . "AND status_matricula != '0'");
$query = $query->fetchAll(PDO::FETCH_ASSOC);


//COSULTAR NO BANCO O CONCEITO DE CADA DISCIPLINA
$res_query_pega_conceito = array();
$disc_matriculada = array();
foreach ($query as $key => $disc_matriculadas) {
    if (isset($disc_matriculadas["cod_conceito"])) {
        $query_pega_conceito = $pdo->query("SELECT conceito FROM conceito WHERE cod_conceito = '" . $disc_matriculadas["cod_conceito"] . "';");
        $res_query_pega_conceito[$key] = $query_pega_conceito->fetchAll(PDO::FETCH_ASSOC);

        //TESTA OS CONCEITOS PARA DETERMINAR SE O ALUNO ESTÁ APROVADO OU NAO NAS DISCIPLINAS
        if ($res_query_pega_conceito[$key]["conceito"] == 0) {

            //RETORNA QUE O ALUNO TEM CONCEITO "NÃO APROVADO" E DEVE CURSAR A DISCIPLINA CONSULTADA NO BANCO
            $status_matricula = true;
            $query_pega_disciplina = $pdo->query("SELECT * FROM disciplina WHERE cod_disc = '" . $disc_matriculadas["cod_disc"] . "';");
            $disc_matriculada[] = $query_pega_disciplina->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION["dados_usuario"][0]["disc_matriculada"] = $disc_matriculada;
        } else {

            //RETORNA QUE O ALUNO TEM CONCEITO "APROVADO" E NÃO DEVE CURSAR AS DISCIPLINAS
            $status_matricula = false;
            $_SESSION["dados_usuario"][0]["disc_matriculada"] = null;
        }
    } else {
        //RETORNA QUE O ALUNO NÃO TEM UM CONCEITO PORQUE NUNCA CURSOU A DISCIPLINA, DEVENDO ENTÃO CURSA-LA
        $status_matricula = true;
        $query_pega_disciplina = $pdo->query("SELECT * FROM disciplina WHERE cod_disc = '" . $disc_matriculadas["cod_disc"] . "';");
        $disc_matriculada[] = $query_pega_disciplina->fetchAll(PDO::FETCH_ASSOC);
    }
}


$qntd_horas = array();
$horas_contabilizadas = array();
$horas_enviadas = array();
$horas_pendentes = array();
$horas_nao_enviadas = array();
$dados_atvd_feita = array();
$aux = array();

foreach ($disc_matriculada as $key => $value) {
    $query = $pdo->query("SELECT 	atvd_feita.cod_disc, atvd_feita.qntd_horas, atvd_feita.horas_validas, atvd_feita.status_envio, atvd_por_curso.carga_horaria_max, atvd_por_curso.limite_horas_atvd, disciplina.nome_disc FROM atvd_feita

            LEFT JOIN atvd_por_curso ON atvd_feita.cod_atvd = atvd_por_curso.cod_atvd
            LEFT JOIN disciplina ON atvd_feita.cod_disc = disciplina.cod_disc
            WHERE atvd_feita.cod_disc = '" . $value[0]["cod_disc"] . "' AND cod_aluno ='" . $_SESSION["dados_usuario"][0]["cod_aluno"] . "' AND atvd_por_curso.cod_curso = '" . $_SESSION["dados_usuario"][0]["cod_curso"] . "';");
    $atvd_feita_horas = $query->fetchAll(PDO::FETCH_ASSOC);
    $aux[] = $atvd_feita_horas;
    $linhas_atvd_feita_horas = count($atvd_feita_horas);

    $qntd_horas_total[$key]["nome_disc"] = $value[0]["nome_disc"];
    $qntd_horas_total[$key]["qntd_horas"] = 0;
    $horas_validas[$key]["nome_disc"] = $value[0]["nome_disc"];
    $horas_validas[$key]["qntd_horas"] = 0;
    $horas_enviadas[$key]["nome_disc"] = $value[0]["nome_disc"];
    $horas_enviadas[$key]["qntd_horas"] = 0;
    $horas_enviadas[$key]["nome_disc"] = $value[0]["nome_disc"];
    $horas_pendentes[$key]["qntd_horas"] = 40;
    $horas_nao_enviadas[$key]["nome_disc"] = $value[0]["nome_disc"];
    $horas_nao_enviadas[$key]["qntd_horas"] = 0;

    if (!empty($atvd_feita_horas)) {

        for ($i = 0; $i < $linhas_atvd_feita_horas; $i++) {
            $qntd_horas_total[$key]["qntd_horas"] +=  $atvd_feita_horas[$i]["qntd_horas"];
            $horas_validas[$key]["qntd_horas"] += $atvd_feita_horas[$i]["horas_validas"];
      
            if ($atvd_feita_horas[$i]["status_envio"] == 1) {
              $horas_enviadas[$key]["qntd_horas"] += $atvd_feita_horas[$i]["qntd_horas"];
              $horas_pendentes[$key]["qntd_horas"] -= $atvd_feita_horas[$i]["horas_validas"];
            }
          }

        
        $horas_nao_enviadas[$key]["qntd_horas"] = $qntd_horas_total[$key]["qntd_horas"] - $horas_enviadas[$key]["qntd_horas"];
    } else {

        $qntd_horas_total[$key]["qntd_horas"] = null;
        $horas_validas[$key]["qntd_horas"] = null;
        $horas_enviadas[$key]["qntd_horas"] = null;
        $horas_pendentes[$key]["qntd_horas"] = null;
        $horas_nao_enviadas[$key]["qntd_horas"] = null;
    }
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

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
                        <a href="index.php">
                            <i class="bi bi-circle"></i><span>Visualizar Atividades</span>
                        </a>
                    </li>
                    <li>
                        <a href="gerenciar-alunos/cadastrar-alunos.php" class="active">
                            <i class="bi bi-circle"></i><span>Enviar Atividadess</span>
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
            <h1>Enviar Atividades</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.php">Visualizar Atividades</a></li>
                    <li class="breadcrumb-item active">Enviar Atividades</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="apexChart"></div>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    var options = {
                                        colors: ['#0d6efd', '#dc3545', '#ffc107', '#198754', '#0dcaf0'],
                                        series: [{
                                            name: 'Registradas',
                                            data: [
                                                <?php echo $qntd_horas_total[0]["qntd_horas"]; ?>,
                                                <?php echo $qntd_horas_total[1]["qntd_horas"]; ?>
                                            ]
                                        }, {
                                            name: 'Não Enviadas',
                                            data: [
                                                <?php echo $horas_nao_enviadas[0]["qntd_horas"]; ?>,
                                                <?php echo $horas_nao_enviadas[1]["qntd_horas"]; ?>
                                            ]
                                        }, {
                                            name: 'Válidas',
                                            data: [
                                                <?php echo $horas_validas[0]["qntd_horas"]; ?>,
                                                <?php echo $horas_validas[1]["qntd_horas"]; ?>
                                            ]
                                        }, {
                                            name: 'Enviadas',
                                            data: [
                                                <?php echo $horas_enviadas[0]["qntd_horas"]; ?>,
                                                <?php echo $horas_enviadas[1]["qntd_horas"]; ?>
                                            ]
                                        }, {
                                            name: 'Pendentes',
                                            data: [
                                                <?php echo $horas_pendentes[0]["qntd_horas"]; ?>,
                                                <?php echo $horas_pendentes[1]["qntd_horas"]; ?>
                                            ]
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 160,
                                            stacked: true,
                                            stackType: '100%'
                                        },
                                        plotOptions: {
                                            bar: {
                                                horizontal: true,
                                            },
                                        },
                                        stroke: {
                                            width: 0,
                                            colors: ['#fff']
                                        },
                                        title: {
                                            text: 'Atividades Enviadas'
                                        },
                                        xaxis: {
                                            categories: [
                                                <?php
                                                if (!empty($aux[0])) {
                                                    echo "'TAA001'";
                                                }
                                                ?>,
                                                <?php
                                                if (!empty($aux[1])) {
                                                    echo "'TAA002'";
                                                }
                                                ?>
                                            ],
                                        },
                                        tooltip: {
                                            y: {
                                                formatter: function(val) {
                                                    return val + " Horas"
                                                }
                                            }
                                        },
                                        fill: {
                                            opacity: 1

                                        },
                                        legend: {
                                            position: 'top',
                                            horizontalAlign: 'left',
                                            offsetX: 40
                                        }
                                    };

                                    var chart = new ApexCharts(document.querySelector("#apexChart"), options);
                                    chart.render();
                                });
                            </script>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Envie as atividades de acordo com a disciplina.</h5>

                            <!-- Table with stripped rows -->
                            <table id="exemple" class="table datatable">
                                <thead>
                                    <tr>
                                    <tr>
                                        <th class="datatable-collumn" scope="col">#</th>
                                        <th class="datatable-collumn" scope="col">Disciplina</th>
                                        <th class="datatable-collumn" scope="col">Tipo Atvd</th>
                                        <th class="datatable-collumn" scope="col">Horas Válidas</th>
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
                                                <?php echo $atvd_feita["qntd_horas"] . " horas"; ?>
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
                                                if (isset($atvd_feita["cod_feedback"])) {
                                                    echo "<span class='badge bg-success'>Recebido</span>";
                                                } else {
                                                    echo "<span class='badge bg-warning text-dark'>Não recebido</span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <?php
                                                    if (!isset($atvd_feita["cod_feedback"]) && $atvd_feita["status_envio"] == 0) {
                                                    ?>
                                                        <div class="div-datatable-collumn">
                                                            <button class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="div-datatable-collumn" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Aguarde o feedback para poder editar!">
                                                            <button class="btn btn-sm btn-outline-primary" disabled>
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="div-datatable-collumn">
                                                        <button class="btn btn-sm btn-outline-secondary">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </button>
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Somas atividades</h5>


                        </div>
                    </div>
                </div>
            </div>

        </section>

        <script>
            // Quando o valor do select for alterado
            document.getElementById('tipoAtvd').addEventListener('change', function() {
                var opcaoSelecionada = this.value;

                // Crie a requisição para o arquivo PHP
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Receba os dados JSON da resposta
                        var data = JSON.parse(this.responseText);
                        console.log(data); // Verifique o conteúdo do JSON no console do navegador

                        // Limpe a tabela antes de preenchê-la novamente
                        var tableBody = document.getElementById('tabelaDadosAtvdFazer').getElementsByTagName('tbody')[0];
                        tableBody.innerHTML = '';

                        // Obtenha as chaves do primeiro objeto do JSON 
                        var keys = Object.keys(data[0]);

                        // Itere sobre as chaves e preencha a tabela
                        for (var i = 0; i < keys.length; i++) {
                            var row = tableBody.insertRow();
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            cell1.innerHTML = keys[i];
                            cell2.innerHTML = data[0][keys[i]];
                        }

                    }
                };

                // Envie a requisição para o arquivo PHP com a opção selecionada como parâmetro
                xhttp.open('GET', 'consulta-atividades.php?opcao=' + opcaoSelecionada, true);
                xhttp.send();
            });
        </script>
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