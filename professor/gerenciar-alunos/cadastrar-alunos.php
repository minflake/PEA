<?php 
  session_start();

  // Verificar se o usuário está logado
  if (!isset($_SESSION["logado"]) || $_SESSION["logado"] !== true) {
    header("Location: ../index.php");
    exit();
  }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Cadastrar Alunos</title>
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

  <!-- JS Liberies -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="../../assets/jquery/jquery-ui.css">

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
        <a class="nav-link" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person"></i><span>Gerenciar Alunos</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-alunos/index.php">
              <i class="bi bi-circle"></i><span>Visualizar Alunos</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-alunos/cadastrar-alunos.php" class="active">
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
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-text"></i><span>Gerenciar Devolutivas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../gerenciar-relatorios/index.php">
              <i class="bi bi-circle"></i><span>Vizualizar Relatórios</span>
            </a>
          </li>
          <li>
            <a href="../gerenciar-relatorios/dar-feedback.php">
              <i class="bi bi-circle"></i><span>Dar feedback</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bx bxs-graduation"></i><span>Gerenciar Conceitos  </span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
      <h1>Cadastrar Alunos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php">Gerenciar Alunos</a></li>
          <li class="breadcrumb-item active">Cadastrar Alunos</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section>

    
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Informe os dados do aluno</h5>
              
              <!-- Floating Labels Form -->
              <form class="row g-3 needs-validation" action="processa-cadastrar-alunos.php" method="post" novalidate>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingNome" placeholder="Nome" name="nome" required>  
                    <label for="floatingNome">Nome</label>
                    <div class="invalid-feedback">
                      Insira o nome.
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingSobrenome" placeholder="Sobrenome" name="sobrenome" required>
                    <label for="floatingSobrenome">Sobrenome</label>
                    <div class="invalid-feedback">
                      Insira o sobrenome.
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-12">
                      <span>Data de Nascimento</span>
                    </div>
                    <div class="col-4">
                      <select id="dia" name="dia" class="form-select" style="height: 58px;" required>
                        <option value="" disabled selected>Dia</option>
                        <!-- Loop para exibir todos os dias do mês -->
                        <?php
                        for ($dia = 1; $dia <= 31; $dia++) {
                            echo "<option value='$dia'>$dia</option>";
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback">
                        Insira o dia.
                      </div>
                    </div>
                    <div class="col-4">
                      <select id="mes" name="mes" class="form-select" style="height: 58px;" required>
                        <option value="" disabled selected>Mês</option>
                        <!-- Loop para exibir todos os meses -->
                        <?php
                        $meses = array(
                            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                        );
                        foreach ($meses as $numero => $nome) {
                            echo "<option value='$numero'>$nome</option>";
                        }
                        ?>    
                      </select>
                      <div class="invalid-feedback">
                        Insira o mês.
                      </div>
                    </div>
                    <div class="col-4">
                      <select id="ano" name="ano" class="form-select" style="height: 58px;" required>
                        <option value="" disabled selected>Ano</option>
                        <?php
                          for ($ano = 2023; $ano >= 1900; $ano--) {
                              echo "<option value='$ano'>$ano</option>";
                          }
                        ?>
                      </select>
                      <div class="invalid-feedback">
                          Insira o ano.
                        </div>  
                    </div> 
                  </div>
                  
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control meu-teste" id="cpf" placeholder="CPF" name="cpf" oninput="formatarCPF()" maxlength="14" required>
                    <label for="cpf">CPF</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" name="ra" class="form-control" id="floatingRa" placeholder="RA" maxlength="13"  required>
                    <label for="floatingRa">RA</label>
                    <div class="invalid-feedback">
                      Insira o RA.
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="E-mail" required>
                    <label for="floatingEmail">E-mail</label>
                    <div class="invalid-feedback">
                      Insira um e-mail válido!
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <select id="curso" name="curso" class="form-select" style="height: 58px;" required>
                    <option value="" disabled selected>Selecione o Curso</option>
                    <?php 
                      require_once("../../conexao.php");
                      $query_pega_curso = $pdo -> query("SELECT * FROM curso");
                      $res_query_pega_curso = $query_pega_curso -> fetchAll(PDO::FETCH_ASSOC);
                      foreach ($res_query_pega_curso as $curso) {
                        echo "<option value=\"" . $curso['cod_curso'] . "\">" . $curso['nome_curso'] . "</option>";
                      }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Informe o curso.
                  </div>
                </div>
                <div class="col-md-5">
                  <select id="semestre" name="semestre" class="form-select" style="height: 58px;" required>
                    <option value="" disabled selected>Selecione o Semestre</option>
                    <?php 
                      for ($semestre=1; $semestre <= 10 ; $semestre++) { 
                        echo "<option value=\"$semestre\">$semestre</option>";
                      }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Informe o semestre    .
                  </div>
                </div>
                <div class="col-md-2 d-flex-collunm">
                  <div class="form-check align-items-center d-flex">
                    <input class="form-check-input" type="checkbox" id="TAA001" name="TAA001">
                    <label class="form-check-label" for="TAA001">
                      &nbsp;TAA001
                    </label>
                  </div>
                  <div class="form-check align-items-center d-flex">
                    <input class="form-check-input" type="checkbox" id="TAA002" name="TAA002">
                    <label class="form-check-label" for="TAA002">
                      &nbsp;TAA002
                    </label>
                  </div>  
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" onclick="validarCPF()">Cadastrar</button>
                </div>
              </form><!-- End floating Labels Form -->

              <?php 
              if (isset($_SESSION['status_formulario'])) {
                switch ($_SESSION['status_formulario']) {
                  case true:
                    echo '<div class="row justify-content-center">';
                      echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div class="alert alert-success alert-dismissible fade show " role="alert">';
                          echo 'Cadastro efetuado com sucesso!';
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
                          echo 'Erro ao efetuar o cadastro, contate o administrador!';
                          echo '<button type="button" class="btn-close" data-bs-dismiss="alert" echo aria-label="Close"></button>';
                        echo '</div>';
                      echo '</div>'; 
                    echo '</div>';
                    unset($_SESSION['status_formulario']);
                    break;
                  default:
                    unset($_SESSION['status_formulario']);
                    break;
                }
              }
              ?>

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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>

</html>