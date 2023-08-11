<?php
session_start();
require_once("../../conexao.php");
// Verificar se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
  header("Location: ../index.php");
  exit();
}

if (!isset($_GET)) {
  header("Location: index.php");
  exit();
}


$cod_relatorio = $_GET["cod_relatorio"];

$query = $pdo->query("SELECT aluno.nome AS nome_aluno, aluno.sobrenome AS sobrenome_aluno, aluno.ra, curso.nome_curso, aluno.semestre, aluno.email, relatorio.cod_relatorio, conceito.conceito, conceito.data_criacao, disciplina.nome_disc, relatorio.horas_validadas, professor.nome AS nome_prof, professor.sobrenome AS sobrenome_prof

FROM relatorio
LEFT JOIN aluno ON relatorio.cod_aluno = aluno.cod_aluno
LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
LEFT JOIN conceito ON relatorio.cod_relatorio = conceito.cod_conceito
LEFT JOIN disciplina ON relatorio.cod_disc = disciplina.cod_disc
LEFT JOIN professor ON conceito.cod_professor = professor.cod_professor
WHERE relatorio.cod_relatorio = '$cod_relatorio';");

$dados_relatorio = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT atvd_a_fazer.tipo_atvd, atvd_a_fazer.categoria_atvd, atvd_feita.cod_atvd_feita, atvd_feita.descricao_atvd, atvd_feita.qntd_horas, atvd_feita.horas_validas, atvd_feita.data_atvd, atvd_feita.data_envio, arquivos.nome_arquivo_original, atvd_feita.status_arquivamento, atvd_feita.status_avaliacao
FROM atvd_feita
LEFT JOIN arquivos ON atvd_feita.cod_arquivo = arquivos.cod_arquivo
LEFT JOIN atvd_a_fazer ON atvd_feita.cod_atvd = atvd_a_fazer.cod_atvd
WHERE atvd_feita.cod_relatorio = '$cod_relatorio'
AND atvd_feita.status_envio = '1';");

$dados_atvd_feita = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT atvd_feita.horas_validas, feedback.feedback
FROM atvd_feita
LEFT JOIN feedback ON atvd_feita.cod_atvd_feitA = feedback.cod_atvd_feita
WHERE atvd_feita.cod_relatorio = '$cod_relatorio';");
$horas_validadas = $query->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dar Feedback</title>
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
          <div class="d-none d-block container-nome-ferramenta">
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
              <span>Professor</span>
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
        <a class="nav-link collapsed" href="../prazos/index.php">
          <i class="bi bi-clock"></i>
          <span>Gerenciar Prazos</span>
        </a>
      </li><!-- End Blank Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="cadastrar-regulamento/index.php">
          <i class="bi bi-file-earmark"></i>
          <span>Cadastrar Regulamento</span>
        </a>
      </li><!-- End Blank Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Gerenciar Alunos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-alunos/index.php">
              <i class="bi bi-circle"></i><span>Visualizar Alunos</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-alunos/cadastrar-alunos.php">
              <i class="bi bi-circle"></i><span>Cadastrar Alunos</span>
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

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-book"></i><span>Gerenciar Atividades</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-atividades/index.php">
              <i class="bi bi-circle"></i><span>Visualizar Atividades</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-atividades/cadastrar-atividades.php">
              <i class="bi bi-circle"></i><span>Cadastrar Atividades</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-atividades/arquivar-atividades.php">
              <i class="bi bi-circle"></i><span>Arquivar Atividades</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Extrair Relatório</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-text"></i><span>Gerenciar Devolutivas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-relatorios/index.php">
              <i class="bi bi-circle"></i><span>Vizualizar Relatórios</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-relatorios/dar-feedback.php" class="active">
              <i class="bi bi-circle"></i><span>Dar feedback</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Extrair Relatório</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-graduation"></i><span>Gerenciar Conceitos </span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-conceitos/index.php">
              <i class="bi bi-circle"></i><span>Visualizar conceitos</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-conceitos/atribuir-conceito.php">
              <i class="bi bi-circle"></i><span>Atribuir conceitos</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

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
      <h1>Atribuir Conceitos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php">Gerenciar Devolutivas</a></li>
          <li class="breadcrumb-item active">Visualizar Relatórios</li>
          <li class="breadcrumb-item active">Dar Feedback</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section class="section profile">



      <div class="card">



        <div class="card-body">
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
              <div class="row">
                <div class="col-md-2 img-perfil-relatorio" style="display: flex;">
                  <img style=" object-fit: contain;max-width: 100%; max-height: auto;" src="../../imagens/download.png" alt="">
                </div>

                <div class="col-md-5 dados-aluno-relatorio" style="padding-left: 30px;">
                  <h5 class="card-title">Dados do Aluno </h5>

                  <div class="row">
                    <div class="col-3 label">Nome</div>
                    <div class="col-9"><?php echo $dados_relatorio[0]["nome_aluno"] . " " . $dados_relatorio[0]["sobrenome_aluno"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-3 label">RA</div>
                    <div class="col-9"><?php echo $dados_relatorio[0]["ra"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-3 label">Curso</div>
                    <div class="col-9"><?php echo $dados_relatorio[0]["nome_curso"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-3 label">Semestre</div>
                    <div class="col-9"><?php echo $dados_relatorio[0]["semestre"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-3 label">Email</div>
                    <div class="col-9"><?php echo $dados_relatorio[0]["email"] ?></div>
                  </div>
                </div>

                <div class="col-md-5">
                  <h5 class="card-title">Dados do Relatório </h5>
                  <div class="row">
                    <div class="col-5  label ">Cód. do Relatório</div>
                    <div class="col-7"><?php echo $dados_relatorio[0]["cod_relatorio"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-5 label">Disciplina</div>
                    <div class="col-7"><?php echo $dados_relatorio[0]["nome_disc"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-5 label">Status</div>
                    <div class="col-7">
                      <?php
                      if (isset($dados_relatorio[0]["conceito"])) {
                        $formato_entrada = 'Y-m-d';
                        $data_criacao = DateTime::createFromFormat($formato_entrada, $dados_relatorio["data_criacao"]);
                        $data_criacao = $data_criacao->format('d/m/Y');
                        if ($dados_relatorio[0]["conceito"] == 1) {
                          echo '<span class="badge bg-sucess">Deferido</span>' . " - " . $data_criacao;
                        } else {
                          echo '<span class="badge bg-danger">Indeferido</span>' . " - " . $data_criacao;
                        }
                      } else {
                        echo '<span class="badge bg-warning text-dark">Não avaliado</span>';
                      }
                      ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-5 label ">Horas Validadas</div>
                    <div class="col-7"><?php echo $dados_relatorio[0]["horas_validadas"] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-5 label ">Avaliador</div>
                    <div class="col-7"><?php echo $dados_relatorio[0]["nome_prof"] . " " . $dados_relatorio[0]["sobrenome_prof"]; ?></div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>


      <?php
      foreach ($dados_atvd_feita as $key => $atvd_feita) {
        $query = $pdo->query("SELECT MAX(cod_feedback) as cod_feedback FROM feedback WHERE cod_atvd_feita = '" . $atvd_feita["cod_atvd_feita"] . "';");
        $query_pega_feedback = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($query_pega_feedback[0]["cod_feedback"])) {
          $cod_feedback = $query_pega_feedback[0]["cod_feedback"];
          $query = $pdo->query("SELECT feedback.cod_feedback, feedback.feedback, feedback.descricao_feedback, feedback.data_criacao, professor.nome AS nome_prof, professor.sobrenome AS sobrenome_prof
          FROM feedback
          LEFT JOIN professor ON feedback.cod_professor = professor.cod_professor
          WHERE cod_feedback = '$cod_feedback';");
          $dados_feedback = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
          $dados_feedback = null;
        }

      ?>
        <!-- Card with header and footer -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title" style="padding: 0; margin: 0;">
              <?php echo "Atividade " . $atvd_feita["cod_atvd_feita"] . " - " . $atvd_feita["tipo_atvd"]; ?>
            </h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="atividade-feita-sub-titulo mt-3 mb-2">
                  <h5>Descricão da atividade</h5>
                </div>
                <div class="atividade-feita-paragrafo">
                  <?php echo $atvd_feita["descricao_atvd"] ?>
                </div>

              </div>
              <div class="col-md-4">
                <div class="atividade-feita-sub-titulo mt-3 mb-2">
                  <h5>Informações da atividade</h5>
                </div>
                <div class="atividade-feita-paragrafo">

                  <?php

                  echo "<div class='col mb-1'>Categoria: " . $atvd_feita["categoria_atvd"] . "</div>";
                  if ($atvd_feita["qntd_horas"] == 1) {
                    echo "<div class='col mb-1'>Horas registradas: " . $atvd_feita["qntd_horas"] . " hora</div>";
                  } else {
                    echo "<div class='col mb-1'>Horas registradas: " . $atvd_feita["qntd_horas"] . " horas</div>";
                  }

                  if ($atvd_feita["horas_validas"] == 1) {
                    echo "<div class='col mb-1'>Horas válidas: " . $atvd_feita["horas_validas"] . " hora</div>";
                  } else {
                    echo "<div class='col mb-1'>Horas válidas: " . $atvd_feita["horas_validas"] . " horas</div>";
                  }

                  $formato_entrada = 'Y-m-d';
                  $data_atvd = DateTime::createFromFormat($formato_entrada, $atvd_feita["data_atvd"]);
                  $data_atvd = $data_atvd->format('d/m/Y');
                  echo "<div class='col mb-1'>Data de realização: $data_atvd</div>";
                  ?>

                </div>
              </div>

              <div class="col-md-3">
                <div class="atividade-feita-sub-titulo mt-3 mb-2">
                  <h5>Status</h5>
                </div>
                <div class="atividade-feita-paragrafo">
                  <?php
                  if ($atvd_feita["status_arquivamento"] == 1) {
                    echo "<div class='col mb-1'><span class='badge bg-secondary'>Arquivada</span></div>";
                  } else {
                    echo "<div class='col mb-1'><span class='badge bg-secondary'>Não arquivada</span></div>";
                  }

                  if (isset($atvd_feita["status_avaliacao"])) {
                    if ($atvd_feita["status_avaliacao"] == 1) {
                      if ($dados_feedback[0]["feedback"] == 1) {
                        echo "<div class='col mb-1'><span class='badge bg-success'>Aprovada</span></div>";

                        echo "<div class='col mb-1'>Avaliador:<br>" . $dados_feedback[0]["nome_prof"] . " " . $dados_feedback[0]["sobrenome_prof"] . "</div>";
  
                        $formato_entrada = 'Y-m-d H:i:s';
                        $data_atvd = DateTime::createFromFormat($formato_entrada, $dados_feedback[0]["data_criacao"]);
                        $data_atvd = $data_atvd->format('d/m/Y - H:i:s');
                        echo "<div class='col mb-1'>Avaliado em:<br> $data_atvd</div>";
                      } else {
                        echo "<div class='col mb-1'><span class='badge bg-danger'>Reprovada</span></div>";

                        echo "<div class='col mb-1'>Avaliador:<br>" . $dados_feedback[0]["nome_prof"] . " " . $dados_feedback[0]["sobrenome_prof"] . "</div>";
  
                        $formato_entrada = 'Y-m-d H:i:s';
                        $data_atvd = DateTime::createFromFormat($formato_entrada, $dados_feedback[0]["data_criacao"]);
                        $data_atvd = $data_atvd->format('d/m/Y - H:i:s');
                        echo "<div class='col mb-1'>Avaliado em:<br> $data_atvd</div>";
                      }

                    } else {
                      echo "<div class='col mb-1'><span class='badge bg-warning text-dark'>Não avaliada</span></div>";
                    }
                  }
                  ?>
                </div>
              </div>

              <div class="col-md-1">
                <div class="atividade-feita-sub-titulo mt-3 mb-2 d-flex align-items-center justify-content-center">
                  <h5>Ações</h5>
                </div>
                <div class="atividade-feita-paragrafo align-items-center justify-content-center">
                  <div class="mb-1 d-flex align-items-center justify-content-center" title="Dar feedback">
                    <form class="formCodAtvdFeita" action="processa-cod-atvd-feita.php" method="get">
                      <input type="number" name="cod_atvd_feita" value="<?php echo $atvd_feita["cod_atvd_feita"]; ?>" hidden>
                      <button type="submit" class="btn btn-sm btn-outline-primary botaoAbrirModal botao-abrir-modal" data-bs-target="#verticalycentered" data-bs-toggle="modal">
                        <i class="bi bi-caret-right-fill"></i>
                      </button>
                    </form>
                  </div>
                  <div class="d-flex align-items-center justify-content-center">
                    <form class="formAnexo" action="processa-atividades-feitas.php" method="get">
                      <input name="cod_atvd_feita" type="number" value="<?php echo $atvd_feita["cod_atvd_feita"]; ?>" hidden>
                      <button id="anexo" type="submit" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-paperclip"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <?php
            $formato_entrada = 'Y-m-d H:i:s';
            $data_envio = DateTime::createFromFormat($formato_entrada, $atvd_feita["data_envio"]);
            $data_envio = $data_envio->format('d/m/Y, à\s  H:i:s');
            echo "Atividade enviada em: " . $data_envio . ".";
            ?>
          </div>
        </div>
        <!-- End Card with header and footer -->
      <?php
      }
      ?>



      <!-- Vertically centered Modal -->
      <div class="modal fade" id="verticalycentered" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form id="formEnviarFeedback" class="formEnviarFeedback needs-validation" action="processa-salvar-feedback.php" method="post" novalidate>
              <div class="modal-header">
                <h5 class="modal-title">Dar devolutiva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body row g-3 ">
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="" id="floatingDescricaoFeedback" style="height: 132px;" name="descricao_feedback"></textarea>
                    <label for="floatingDescricaoFeedback">Feedback</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <select class="form-select" placeholder="" id="floatingFeedback" name="feedback" required></textarea>
                      <option value="" disabled selected>Atribua um status</option>
                      <option value="1">Aprovada</option>
                      <option value="0">Reprovada</option>
                    </select>
                    <label for="floatingFeedback">Status</label>
                  </div>
                </div>
                <input name="cod_atvd_feita" id="codAtvdFeita" hidden>
                <div class="col-12">
                  <div id="apexChart"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </form>
          </div>
        </div>
      </div><!-- End Vertically centered Modal-->
    </section>

    <!-- ALERTAS -->
    <?php
    if (isset($_SESSION['status_formulario'])) {
      if ($_SESSION['status_formulario'] === true) {
    ?>
        <div class="row justify-content-center">
          <div class="col-12 d-flex justify-content-center alerts-settings">
            <div class="alert alert-success alert-dismissible fade show " role="alert">
              Feedback cadastrado com sucesso!
              <button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>
            </div>
          </div>
        </div>
      <?php
        unset($_SESSION['status_formulario']);
      } else {
      ?>
        <div class="row justify-content-center">
          <div class="col-12 d-flex justify-content-center alerts-settings">
            <div class="alert alert-danger alert-dismissible fade show " role="alert">
              Erro ao cadastrar atividade, contate o administrador!
              <button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>
            </div>
          </div>
        </div>
    <?php
        unset($_SESSION['status_formulario']);
      }
    }
    ?>

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


  <!-- Scripts -->
  <script>
    $(document).ready(function() {
      // Captura o evento de envio do formulário
      $('.formCodAtvdFeita').submit(function(g) {
        g.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        var formData = $(this).serialize();

        // Faz uma solicitação AJAX usando a função $.ajax do jQuery
        $.ajax({
          type: 'GET', // Método de envio (pode ser 'GET' ou 'POST')
          url: 'processa-cod-atvd-feita.php', // URL do script que processará os dados
          data: formData, // Dados do formulário serializados
          success: function(response) {
            var valorBotao = document.getElementById('codAtvdFeita');
            valorBotao.value = response;

          },
          error: function(xhr, status, error) {
            // Função a ser executada quando ocorrer um erro na solicitação
            console.error('Erro na solicitação:', error);
            console.log('Resposta do servidor:', response);
          }
        });
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      $('.formAnexo').submit(function(f) {
        f.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        var formData = $(this).serialize();

        // Faz uma solicitação AJAX usando a função $.ajax do jQuery
        $.ajax({
          type: 'GET', // Método de envio (pode ser 'GET' ou 'POST')
          url: 'processa-atividades-feitas.php', // URL do script que processará os dados
          data: formData, // Dados do formulário serializados
          xhrFields: {
            responseType: 'blob'
          },
          success: function(data, status, xhr) {
            var filenameWithExtension = xhr.getResponseHeader('X-Filename');

            var blob = new Blob([data], {
              type: 'application/octet-stream'
            });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filenameWithExtension;
            link.click();
            URL.revokeObjectURL(link.href);
          },
          error: function(xhr, status, error) {
            // Função a ser executada quando ocorrer um erro na solicitação
            console.error('Erro na solicitação:', error);
            console.log('Resposta do servidor:', response);
          }
        });
      });
    });
  </script>

<script>
    $(document).ready(function() {
      // Captura o evento de envio do formulário
      $('.formEnviarFeedback').submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        // Coleta os dados do formulário
        var formData = $(this).serialize();

        // Faz uma solicitação AJAX usando a função $.ajax do jQuery
        $.ajax({
          type: 'POST', // Método de envio (pode ser 'GET' ou 'POST')
          url: 'processa-salvar-feedback.php', // URL do script que processará os dados
          data: formData, // Dados do formulário serializados
          success: function(response) {
            if (response === true) {
              console.log(response);
              window.location.reload(true);

            } else {
              console.log(response);
              window.location.reload(true);
            }
          },
          error: function(xhr, status, error) {
            // Função a ser executada quando ocorrer um erro na solicitação
            console.error('Erro na solicitação:', error);
            console.log('Resposta do servidor:', response);
          }
        });
      });
    });
  </script>

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