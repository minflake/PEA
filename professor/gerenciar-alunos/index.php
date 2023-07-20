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

  <title>Gerenciar Alunos</title>
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
  <script>
    function editarAlunos(ra) {
      fetch('processa-index.php', {
        
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'ra=' + encodeURIComponent(ra)
      })
      .then(response => response.text())
      .then(data => {
        var cod_aluno = data;
        
        if (cod_aluno !== null) {
          window.location.href = "editar-alunos.php";
          
        } else {
          window.alert ("ERRO, CONTATE O ADMINISTRADOR!!!!");
        }
     
      })
      .catch(error => {
        // Lidar com erros de requisição aqui
        window.alert("ERRO, CONTATE O ADMINISTRADOR!!!")
        console.error(error);
      });
    }
  </script>
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
            <a href="../gerenciar-alunos/index.php" class="active">
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
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Extrair Relatório</span>
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
      <h1>Gerenciar Alunos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item">Gerenciar Alunos</li>
          <li class="breadcrumb-item active">Visualizar Alunos</li>
          
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section>
      <div class="row gerenciar-alunos-nav">

        <div class="col-4">
          <div class="card info-card sales-card">
            <a href="cadastrar-alunos.php">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-file-earmark-person"></i>
                  </div>
                  <div>
                    <h5 class="card-title">Cadastrar Alunos</h5>
                  </div>
                </div>
                    
                <div class="card-text">
                  <p>
                    Cadastre um novo aluno.
                  </p>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-4">
          <div class="card info-card sales-card">
            <a href="prazos/index.php">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-upload"></i>
                  </div>
                  <div>
                    <h5 class="card-title">Importar Alunos</h5>
                  </div>
                </div>
                    
                <div class="card-text">
                  <p>
                    Importe alunos em massa.
                  </p>
                </div>
              </div>
            </a>
          </div>
        </div>

        <div class="col-4">
          <div class="card info-card sales-card">
            <a href="prazos/index.php">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-file-earmark-pdf"></i>
                  </div>
                  <div>
                    <h5 class="card-title">Extrair Relatório</h5>
                  </div>
                </div>
                    
                <div class="card-text">
                  <p>
                    Relatório de alunos cadastrados.
                  </p>
                </div>
              </div>
            </a>
          </div>
        </div>

      </div>

      <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <h5 class="card-title">Alunos Cadastrados</h5>
                </div>
                <div class="col-6 d-flex justify-content-end align-items-center">
                  <div class="search-bar">
                    <form class="search-form d-flex align-items-center" method="GET" action="processa-index.php">
                      <input type="text" name="pesquisar" placeholder="Digite um RA, CPF ou nome" style="min-width: 220px;" value="<?php if (isset($_SESSION['input_pesquisa'])) {echo $_SESSION['input_pesquisa']; unset($_SESSION['input_pesquisa']);}?>">
                      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                    </form>
                  </div>
                </div>
              </div>
              
              
              <!-- Table with hoverable rows -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">RA</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Cursando</th>
                    <th scope="col">Cadastrado em</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if (isset($_SESSION['resultados'])) {
                      $resultados = $_SESSION['resultados'];
                      $linhas_resultados = count($_SESSION['resultados']);
                      if ($linhas_resultados > 0) {
                        for ($i=0; $i < $linhas_resultados; $i++) { 
                          echo "<tr>";
                                echo "<th scope=\"" . "row" ."\">" . $resultados[$i]['ra'] . "</th>";
                                echo "<td>" . $resultados[$i]['nome'] . " " . $resultados[$i]['sobrenome'] . "</td>";
                                echo "<td>" . $resultados[$i]['nome_curso'] . "</td>";
                                echo "<td>";
    
                                  require_once("../../conexao.php");
                                  $query_listar_disc_matriculada = $pdo -> query("SELECT disc_matriculada.cod_disc, disc_matriculada.cod_aluno, disc_matriculada.cod_conceito, disc_matriculada.status_matricula, disciplina.nome_disc, conceito.conceito
    
                                  FROM disc_matriculada
                                  LEFT JOIN conceito ON disc_matriculada.cod_conceito = conceito.conceito
                                  LEFT JOIN disciplina ON disc_matriculada.cod_disc = disciplina.cod_disc
                                  WHERE cod_aluno = '" . $resultados[$i]['cod_aluno'] . "';");
                                  $query_listar_disc_matriculada = $query_listar_disc_matriculada -> fetchAll(PDO::FETCH_ASSOC);
    
                                  $linhas_disc_matriculada = count($query_listar_disc_matriculada);
                                  for ($j=0; $j < $linhas_disc_matriculada ; $j++) { 
                                    if ($query_listar_disc_matriculada[$j]['status_matricula'] == 0) {
                                      echo "";
                                    } else {
                                      if ($query_listar_disc_matriculada[$j]['cod_conceito'] !== null || $query_listar_disc_matriculada[$j]['cod_conceito'] !== 0) {
                                        if ($query_listar_disc_matriculada[$j]['conceito'] == 0) {
                                          echo $query_listar_disc_matriculada[$j]['nome_disc'] . " " ;
                                        }
                                      } else { 
                                        echo "";
                                      }
                                    }
                                  }
                                  
                                  
                                echo "</td>";
                                $formato_entrada = 'Y-m-d H:i:s';
                                $data_criacao = DateTime::createFromFormat($formato_entrada, $resultados[$i]['data_criacao']);
                                $data_criacao = $data_criacao -> format('d/m/Y H:i:s');
                                echo "<td>" . $data_criacao . "</td>";
                                echo "<td>";
                                  echo "<a href=\"" ."#" . "\"";
                                    echo "onclick=\"" . "editarAlunos('" . $resultados[$i]['ra'] . "')" . "\"" . ">";
                                    echo "<i class='bi bi-pencil-square'></i>";
                                  echo "</a>";
                                  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                  echo "<i class='bi bi-eye-fill'></i>";
                                echo "</td>";
                            echo "</tr>";
                          }
                        unset($_SESSION['resultados']);
                      } else {
                        echo "<tr align='center'>";
                          echo "<td colspan='6' style='color: #9b1825;'>Nenhum resultado encontrado.</td>";
                        echo "</tr>";
                        unset($_SESSION['resultados']);
                      }
                    
                    } else {
                      require_once("../../conexao.php");
                    $query_listar_alunos = $pdo -> query("SELECT
                      aluno.cod_aluno,
                      aluno.ra,
                      aluno.nome,
                      aluno.sobrenome,
                      aluno.data_criacao,
                      curso.nome_curso,
                      disc_matriculada.cod_conceito,
                      disc_matriculada.status_matricula,
                      GROUP_CONCAT(DISTINCT disciplina.nome_disc  SEPARATOR ', ') AS nome_disc
                              
                      FROM aluno
                      LEFT JOIN curso ON aluno.cod_curso = curso.cod_curso
                      LEFT JOIN disc_matriculada ON disc_matriculada.cod_aluno = aluno.cod_aluno
                      LEFT JOIN disciplina ON disciplina.cod_disc = disc_matriculada.cod_disc
                      GROUP BY
                      aluno.ra;
                    ");
                    $query_listar_alunos = $query_listar_alunos -> fetchAll(PDO::FETCH_ASSOC);

                    $linhas_listar_alunos = count($query_listar_alunos);
                    for ($i=0; $i < $linhas_listar_alunos; $i++) { 
                      echo "<tr>";
                            echo "<th scope=\"" . "row" ."\">" . $query_listar_alunos[$i]['ra'] . "</th>";
                            echo "<td>" . $query_listar_alunos[$i]['nome'] . " " . $query_listar_alunos[$i]['sobrenome'] . "</td>";
                            echo "<td>" . $query_listar_alunos[$i]['nome_curso'] . "</td>";
                            echo "<td>";

                              require_once("../../conexao.php");
                              $query_listar_disc_matriculada = $pdo -> query("SELECT disc_matriculada.cod_disc, disc_matriculada.cod_aluno, disc_matriculada.cod_conceito, disc_matriculada.status_matricula, disciplina.nome_disc, conceito.conceito

                              FROM disc_matriculada
                              LEFT JOIN conceito ON disc_matriculada.cod_conceito = conceito.conceito
                              LEFT JOIN disciplina ON disc_matriculada.cod_disc = disciplina.cod_disc
                              WHERE cod_aluno = '" . $query_listar_alunos[$i]['cod_aluno'] . "';");
                              $query_listar_disc_matriculada = $query_listar_disc_matriculada -> fetchAll(PDO::FETCH_ASSOC);

                              $linhas_disc_matriculada = count($query_listar_disc_matriculada);
                              for ($j=0; $j < $linhas_disc_matriculada ; $j++) { 
                                if ($query_listar_disc_matriculada[$j]['status_matricula'] == 0) {
                                  echo "";
                                } else {
                                  if ($query_listar_disc_matriculada[$j]['cod_conceito'] !== null || $query_listar_disc_matriculada[$j]['cod_conceito'] !== 0) {
                                    if ($query_listar_disc_matriculada[$j]['conceito'] == 0) {
                                      echo $query_listar_disc_matriculada[$j]['nome_disc'] . " " ;
                                    }
                                  } else { 
                                    echo "";
                                  }
                                }
                              }
                              
                              
                            echo "</td>";
                            $formato_entrada = 'Y-m-d H:i:s';
                            $data_criacao = DateTime::createFromFormat($formato_entrada, $query_listar_alunos[$i]['data_criacao']);
                            $data_criacao = $data_criacao -> format('d/m/Y H:i:s');
                            echo "<td>" . $data_criacao . "</td>";
                            echo "<td>";
                              echo "<a href=\"" ."#" . "\"";
                                echo "onclick=\"" . "editarAlunos('" . $query_listar_alunos[$i]['ra'] . "')" . "\"" . ">";
                                echo "<i class='bi bi-pencil-square'></i>";
                              echo "</a>";
                              echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                              echo "<i class='bi bi-eye-fill'></i>";
                            echo "</td>";
                        echo "</tr>";
                      }
                    }
                    
                  ?>
                </tbody>
              </table>
              <!-- End Table with hoverable rows -->

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