<?php
session_start();
require_once("../../conexao.php");
// Verificar se o usuário está logado
if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
  header("Location: ../index.php");
  exit();
}

$query = $pdo->query("SELECT * FROM curso");
$cursos = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query("SELECT * FROM disciplina");
$disciplinas = $query->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Gerenciar Relatórios</title>
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

  <style>
    /* Media query for mobile devices */
    @media (max-width: 768px) {

      .table-responsive th, .table-responsive td {
        display: block;
        width: 100%;
      }

      .table-responsive th {
        text-align: center;
      }
    }
  </style>

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
            <a href="index.php" class="active">
              <i class="bi bi-circle"></i><span>Visualizar Relatórios</span>
            </a>
          </li>
          <li>
            <a href="dar-feedback.php">
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
      <h1>Gerenciar Devolutivas </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Gerenciar Devolutivas</li>
          <li class="breadcrumb-item active">Visualizar Relatórios</li>

        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Relatórios Recebidos</h5>

          <!-- Vertically centered Modal -->
          <div class="col-12 d-grid gap-2 mt-2 mb-4">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
              Filtrar Relatórios
            </button>
          </div>

          <div class="modal fade" id="basicModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="processa-index.php" method="get">
                  <div class="modal-header">
                    <h5 class="modal-title">Selecionar Filtros</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <select class="form-select" id="selectCurso" name="curso">
                          <option value="" selected disabled>Selecione o curso</option>
                          <?php
                          foreach ($cursos as $key => $value) {
                          ?>
                            <option value="<?php echo $value["cod_curso"]; ?>"><?php echo $value["nome_curso"]; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <label for="selectCurso">Curso</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <select class="form-select" id="selectDisciplina" name="disciplina">
                          <option value="" selected disabled>Selecione a Disciplina</option>
                          <?php
                          foreach ($disciplinas as $key => $value) {
                          ?>
                            <option value="<?php echo $value["cod_disc"]; ?>"><?php echo $value["nome_disc"]; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                        <label for="selectDisciplina">Disciplina</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <select class="form-select" id="selectSemestre" name="semestre">
                          <option value="" selected disabled>Selecione o semestre</option>
                          <?php
                          for ($i = 1; $i <= 10; $i++) {
                            echo "<option value=\"" . $i . "\">" . $i . "º Semestre</option>";
                          }
                          ?>
                        </select>
                        <label for="selectSemestre">Semestre</label>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-floating mb-3">
                        <select class="form-select" id="selectStatus" name="status">
                          <option value="" selected disabled>Selecione o Status</option>
                          <option value="1">Deferido</option>
                          <option value="0">Indeferido</option>
                        </select>
                        <label for="selectStatus">Status</label>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- End Vertically centered Modal-->

          <?php
          if (isset($_SESSION["relatorios"]) && !empty($_SESSION["relatorios"])) {
          ?>
            <!-- Table with stripped rows -->
            <table class="table display nowrap"  style="width:100%" id="tabelaGerenciarRelatorios">
              <thead>
                <tr>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Curso</th>
                  <th scope="col">Disciplina</th>
                  <th scope="col">RA</th>
                  <th scope="col">Aluno</th>
                  <th scope="col">Horas</th>
                  <th scope="col">Data</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ações</th>
                </tr>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($_SESSION["relatorios"] as $key => $relatorio) {
                ?>
                  <tr>
                    <th scope="row"><?php echo $relatorio["cod_relatorio"]; ?></th>
                    <td><?php echo $relatorio["nome_curso"]; ?></td>
                    <td><?php echo $relatorio["nome_disc"]; ?></td>
                    <td><?php echo $relatorio["ra"]; ?></td>
                    <td><?php echo $relatorio["nome"] . " " . $relatorio["sobrenome"]; ?></td>
                    <td>
                      <?php
                      if ($relatorio["horas_enviadas"] == 1) {
                        echo $relatorio["horas_enviadas"] . " hora";
                      } else {
                        echo $relatorio["horas_enviadas"] . " horas";
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                      $formato_entrada = 'Y-m-d H:i:s';
                      $data_envio = DateTime::createFromFormat($formato_entrada, $relatorio["data_envio"]);
                      $data_envio = $data_envio->format('d/m/Y');
                      echo $data_envio;
                      ?>
                    </td>
                    <td>
                      <?php
                      if (isset($relatorio["conceito"])) {
                        if ($relatorio["conceito"] == 1) {
                          echo '<span class="badge bg-success">Deferido</span>';
                        } else {
                          echo '<span class="badge bg-danger">Indeferido</span>';
                        }
                      } else {
                        echo '<span class="badge bg-warning text-dark">Recebido</span>';
                      }
                      ?>
                    </td>
                    <td>
                      <form action="dar-feedback.php" method="get">
                        <input name="cod_relatorio" type="number" value="<?php echo $relatorio["cod_relatorio"]; ?>" hidden>
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                          <i class="bi bi-eye-fill"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          <?php
          } elseif (isset($_SESSION["relatorios"]) && empty($_SESSION["relatorios"])) {
          ?>
            <table class="table table-responsive">
              <thead>
                <tr>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Curso</th>
                  <th scope="col">Disciplina</th>
                  <th scope="col">RA</th>
                  <th scope="col">Aluno</th>
                  <th scope="col">Horas</th>
                  <th scope="col">Data</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ações</th>
                </tr>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="9" align="center">Nenhum resultado encontrado.</td>
                </tr>
              </tbody>
            </table>
          <?php
          } else {
            # code...
          ?>
            <table class="table table-responsive">
              <thead>
                <tr>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Curso</th>
                  <th scope="col">Disciplina</th>
                  <th scope="col">RA</th>
                  <th scope="col">Aluno</th>
                  <th scope="col">Horas</th>
                  <th scope="col">Data</th>
                  <th scope="col">Status</th>
                  <th scope="col">Ações</th>
                </tr>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="9" align="center">Selecione um filtro.</td>
                </tr>
              </tbody>
            </table>

          <?php
          }
          ?>
          <!-- End Table with stripped rows -->

          <form action="processa-index.php" method="get" class="d-flex justify-content-center">
            <input type="number" value="1" hidden>
            <div class="col-2 d-grid gap-2 mt-3 mb-4">
              <!-- Coloque este botão onde você quiser que o clone dos selects seja inserido -->
              <button type="submit" class="btn btn-outline-secondary">
                Limpar Filtros
              </button>
            </div>
          </form>


        </div>
      </div>

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


  <!-- Scripts -->
  <script>
    /**
     * Initiate Datatables
     */
    const tabelaGerenciarRelatorios = {
      //scrollX: "2000px",
      responsive: true,
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      lengthMenu: [5, 10, 15, 20],
      columnDefs: [{
          className: "datatable-collumn-centered",
          targets: [8]
        },
        {
          orderable: false,
          targets: [3, 5, 8]
        },
        {
          searchable: false,
          targets: [5, 6, 7, 8]
        },
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
      $('#tabelaGerenciarRelatorios').DataTable(tabelaGerenciarRelatorios);
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