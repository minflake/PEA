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

  <title>Cadastrar Atividades</title>
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
        <a class="nav-link" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-book"></i><span>Gerenciar Atividades</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="index.php">
              <i class="bi bi-circle"></i><span>Visualizar Atividades</span>
            </a>
          </li>
          <li>
            <a href="cadastrar-atividades.php" class="active">
              <i class="bi bi-circle"></i><span>Cadastrar Atividades</span>
            </a>
          </li>
          <li>
            <a href="arquivar-atividades.php">
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
              <i class="bi bi-circle"></i><span>Visualizar Relatórios</span>
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
      <h1>Cadastrar Atividades</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
          <li class="breadcrumb-item"><a href="index.php">Gerenciar Atividades</a></li>
          <li class="breadcrumb-item active">Cadastrar Atividades</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <section>

    
    <div class="card">
            <div class="card-body">
              <h5 class="card-title">Informe os dados a atividade a ser feita.</h5>
              
              <!-- Floating Labels Form -->
              <form id="atividadesForm" class="row g-3 needs-validation" novalidate action="processa-cadastrar-atividades.php" method="post">
                <div class="col-md-8">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Tipo de Atividade" id="floatingTipoAtividade" name="tipoAtividade" required></textarea>
                    <label for="floatingTipoAtividade">Tipo de Atividade</label>
                  </div>
                  <div class="invalid-feedback">
                    Informe o Tipo de Atividade
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <select class="form-select" id="selectCategoria" name="categoria" required>
                      <option value="" selected disabled>Selecione a categoria</option>
                      <option value="Acadêmico-científico">Acadêmico-científico</option>
                      <option value="Cultural">Cultural</option>
                      <option value="Social">Social</option>
                    </select>
                    <label for="floatingSelect">Categoria</label>
                  </div>
                  <div class="invalid-feedback">
                    Informe a categoria.
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="" id="floatingDescricaoAtividade" style="height: 132px;" name="descricaoAtividade" required></textarea>
                    <label for="floatingPassword">Descrição da Atividade</label>
                  </div>
                  <div class="invalid-feedback">
                    Insira a descrição da atividade.
                  </div>
                </div>

                <div class="col-md-5">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="" id="floatingTipoDoc" style="height: 132px;" name="tipoDocumento" required></textarea>
                    <label for="floatingTipoDoc">Tipo de Documento</label>
                  </div>
                  <div class="invalid-feedback">
                    Informe os tipos de documentos comprobatórios válidos.
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="selectLimiteHoras" name="limiteHoras" required>
                      <option value="" selected disabled>Selecione o limite de horas</option>
                      <?php 
                        for ($i=1; $i <= 40 ; $i++) { 
                          echo "<option value=\"" . $i . "\">$i</option>";
                        }
                      ?>
                    </select>
                    <label for="selectLimiteHoras">Limite de horas por atividade</label>
                  </div>
                  <div class="invalid-feedback">
                    Insira o Limite de Horas por atividade.
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="selectCargaMax" name="cargaMax" required>
                      <option value="" selected disabled>Selecione a carga horária máxima</option>
                      <?php 
                        for ($j=1; $j <= 40 ; $j++) { 
                          echo "<option value=\"" . $j . "\">$j</option>";
                        }
                      ?>
                    </select>
                    <label for="selectCargaMax">Carga Horária Máxima</label>
                  </div>
                  <div class="invalid-feedback">
                    Insira a Carga Horária Máxima.
                  </div>
                </div>
                  <div class="col-md-12" id="selectCurso">
                    <div class="form-floating mb-3">
                      <select class="form-select" id="curso_0" name="curso_0" required>
                        <option value="" selected disabled>Selecione o curso da atividade</option>
                        <?php 
                          require_once("../../conexao.php");
                          $query = $pdo -> query("SELECT * FROM curso;");
                          $query = $query -> fetchAll(PDO::FETCH_ASSOC);

                          foreach ($query as $dados_curso) {
                            echo "<option value='" . $dados_curso["cod_curso"] . "'>" . $dados_curso["nome_curso"] . "</option>";
                          }
                        ?>
                      </select>
                      <label for="selectCargaMax">Curso</label>
                    </div>
                    <div class="invalid-feedback">
                      Informe o curso!
                    </div>
                  </div>

                  <input type="hidden" id="contador" name="contador" value="1">

                  <div id="botaoDuplicar" class="col-12 d-grid gap-2 mt-3">
                    <!-- Coloque este botão onde você quiser que o clone dos selects seja inserido -->
                    <button type="button" class="btn btn-outline-primary" onclick="duplicarSelects()">Selecionar outro curso</button>
                  </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
              </form><!-- End floating Labels Form -->

              <script>
                let contador = 1; // Inicialize o contador

                function duplicarSelects() {
                  // Obtenha a referência para as divs que você deseja duplicar
                  const divCurso = document.getElementById('selectCurso');

                  // Clone as divs usando a função cloneNode()
                  const novaDivCurso = divCurso.cloneNode(true);

                  // Crie novos IDs para as divs clonadas
                  const novoCursoId = `selectCurso_${contador}`;

                  // Defina os novos IDs nas divs clonadas
                  novaDivCurso.setAttribute('id', novoCursoId);

                  // Atualize os IDs e names dos selects dentro das divs clonadas
                  const novoCursoSelect = novaDivCurso.querySelector('select');
                  
                  const novoCursoSelectId = `curso_${contador}`;
                  const novoCursoSelectName = `curso_${contador}`;
                  
                  novoCursoSelect.setAttribute('id', novoCursoSelectId);
                  novoCursoSelect.setAttribute('name', novoCursoSelectName);

                  // Incrementar o contador para a próxima duplicação
                  contador++;

                  // Obtenha a referência ao botão que aciona a duplicação
                  const botaoDuplicar = document.getElementById('botaoDuplicar');

                  // Adicione as divs clonadas antes do botão de duplicação
                  const form = document.getElementById('atividadesForm'); // Substitua 'seu-form-id' pelo ID do seu formulário
                  form.insertBefore(novaDivCurso, botaoDuplicar);

                  const contadorInput = document.getElementById('contador');
                  contadorInput.value = contador;
                }
              </script>


              <!-- ALERTAS -->
              <?php 
              if (isset($_SESSION['status_formulario'])) {
                switch ($_SESSION['status_formulario']) {
                  case true:
                    echo '<div class="row justify-content-center">';
                      echo '<div class="col-12 d-flex justify-content-center alerts-settings">';
                        echo '<div class="alert alert-success alert-dismissible fade show " role="alert">';
                          echo 'Atividade cadastrada com sucesso!';
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
                          echo 'Erro ao cadastrar atividade, contate o administrador!';
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