-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2023 at 06:41 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21117949_pea`
--
-- --------------------------------------------------------

--
-- Table structure for table `adm`
--

CREATE TABLE `adm` (
  `cod_adm` tinyint(4) NOT NULL,
  `cod_usuario` mediumint(9) NOT NULL,
  `cpf` char(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL DEFAULT 'Não-Binário',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adm`
--

INSERT INTO `adm` (`cod_adm`, `cod_usuario`, `cpf`, `nome`, `sobrenome`, `genero`, `data_criacao`) VALUES
(5, 2, '52456000803', 'Anthony', 'Ramos', 'Homem', '2023-07-07 06:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

CREATE TABLE `aluno` (
  `cod_aluno` mediumint(9) NOT NULL,
  `cod_curso` tinyint(4) NOT NULL,
  `cod_usuario` mediumint(9) NOT NULL,
  `ra` char(13) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL DEFAULT 'Não-Binário',
  `email` varchar(60) NOT NULL,
  `data_nascimento` date NOT NULL,
  `turma` varchar(20) DEFAULT NULL,
  `semestre` tinyint(4) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aluno`
--

INSERT INTO `aluno` (`cod_aluno`, `cod_curso`, `cod_usuario`, `ra`, `cpf`, `nome`, `sobrenome`, `genero`, `email`, `data_nascimento`, `turma`, `semestre`, `data_criacao`) VALUES
(32, 1, 44, '2940782113002', '52456000803', 'Anthony', 'Ferreira Ramos', 'Homem', 'nazarick97@gmail.com', '2003-03-17', NULL, 6, '2023-07-24 00:33:05'),
(41, 2, 49, '0987654321123', '00000000002', 'Lili', 'Angulo', 'Não-Binário', 'lili@gmail.com', '2003-12-08', NULL, 1, '2023-07-25 18:45:15'),
(42, 1, 50, '4792274788833', '47922747888', 'Max', 'Oliveira', 'Não-Binário', 'theuzinho@gmail.com', '2009-09-16', NULL, 3, '2023-07-25 18:46:26'),
(43, 1, 51, '6t54565435434', '32454324543', 'Lucao', '??', 'Não-Binário', 'lucao@gmail.com', '2000-06-14', NULL, 3, '2023-07-28 05:38:01'),
(44, 1, 52, '2940782113055', '49779921800', 'Alessandro', 'Santos Sousa', 'Homem', 'null_ale@gmail.com', '2001-04-19', NULL, 6, '2023-07-28 17:22:12'),
(45, 1, 53, '5643234565432', '53042132897', 'Gabriel', 'Magagnini', 'Homem', 'gig@gmail.com', '2003-06-23', NULL, 1, '2023-08-02 19:58:53');

--
-- Triggers `aluno`
--
DELIMITER $$
CREATE TRIGGER `tr_inserir_usuario` BEFORE INSERT ON `aluno` FOR EACH ROW BEGIN

    INSERT INTO usuario (senha) VALUES (NEW.data_nascimento);

    -- Obter o ID gerado na inserção anterior
    SET @cod_usuario = LAST_INSERT_ID();

    -- Atualizar a nova linha na tabela 'aluno' com a chave estrangeira
    SET NEW.cod_usuario = @cod_usuario;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `arquivos`
--

CREATE TABLE `arquivos` (
  `cod_arquivo` int(11) NOT NULL,
  `cod_usuario` mediumint(9) NOT NULL,
  `nome_arquivo_original` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `extensao` enum('image/jpeg','image/png','application/pdf') NOT NULL,
  `tamanho` int(11) NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arquivos`
--

INSERT INTO `arquivos` (`cod_arquivo`, `cod_usuario`, `nome_arquivo_original`, `nome_arquivo`, `extensao`, `tamanho`, `caminho_arquivo`, `data_envio`) VALUES
(1, 52, 'Alessandro Santos de Sousa.pdf', '64d594be4f20c_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d594be4f20c_Alessandro Santos de Sousa.pdf', '2023-08-11 01:54:06'),
(2, 52, 'Alessandro Santos de Sousa.pdf', '64d5951d83bad_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d5951d83bad_Alessandro Santos de Sousa.pdf', '2023-08-11 01:55:41'),
(3, 52, 'Alessandro Santos de Sousa.pdf', '64d5955cc2a81_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d5955cc2a81_Alessandro Santos de Sousa.pdf', '2023-08-11 01:56:44'),
(4, 52, 'Alessandro Santos de Sousa.pdf', '64d597ea26784_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d597ea26784_Alessandro Santos de Sousa.pdf', '2023-08-11 02:07:38'),
(5, 52, 'Alessandro Santos de Sousa.pdf', '64d598289d739_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d598289d739_Alessandro Santos de Sousa.pdf', '2023-08-11 02:08:40'),
(6, 52, 'Alessandro Santos de Sousa.pdf', '64d59855cd60a_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d59855cd60a_Alessandro Santos de Sousa.pdf', '2023-08-11 02:09:25'),
(7, 52, 'Alessandro Santos de Sousa.pdf', '64d5999aa75d7_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, '/storage/ssd1/949/21117949/public_html/arquivos/aluno/atvd_feita/64d5999aa75d7_Alessandro Santos de Sousa.pdf', '2023-08-11 02:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `atvd_a_fazer`
--

CREATE TABLE `atvd_a_fazer` (
  `cod_atvd` smallint(6) NOT NULL,
  `cod_professor` mediumint(9) NOT NULL,
  `tipo_atvd` varchar(100) NOT NULL,
  `descricao_atvd` varchar(500) NOT NULL,
  `categoria_atvd` enum('Acadêmico-científico','Cultural','Social') NOT NULL,
  `tipo_doc_comprobatorio` varchar(200) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atvd_a_fazer`
--

INSERT INTO `atvd_a_fazer` (`cod_atvd`, `cod_professor`, `tipo_atvd`, `descricao_atvd`, `categoria_atvd`, `tipo_doc_comprobatorio`, `data_criacao`) VALUES
(23, 1, 'Congressos, Simpósios, Workshops na ÁREA DO CURSO', 'Participação PRESENCIAL ou ONLINE como OUVINTE em congressos, simpósios ou workshop na área do curso.', 'Acadêmico-científico', 'Certificado de participação. Deve ter o nome do evento, data ou período de realização e quantidade de horas.', '2023-07-26 01:55:54'),
(24, 1, 'Participação na ESCOLA DE INOVADORES com projeto (PI) inscrito', 'O Grupo deve fazer a inscrição do seu projeto (PI) na Escola de Inovadores acessando os módulos propostos para validar a participação até a conquista do certificado.', 'Acadêmico-científico', 'Certificado de participação.\r\nDeve ter o nome do evento, data ou\r\nperíodo de realização.\r\nEmitido na plataforma Escola de\r\nInovadores. (link será disponibilizado em\r\nbreve para inscrição).\r\n', '2023-07-26 01:57:50'),
(26, 1, 'WEBINAR na ÁREA DO CURSO', 'Participação ONLINE como OUVINTE em WEBINAR na área do curso.\r\n', 'Acadêmico-científico', 'Certificado de participação. Deve ter o nome do evento, data ou período de realização e quantidade de horas.\r\n', '2023-07-26 05:25:09'),
(27, 1, 'Artigos NÃO INDEXADOS na ÁREA DO CURSO.', 'Publicações de qualquer natureza em revistas, instituições ou empresas relevantes, na área do curso. EXEMPLO: artigos comerciais para jornais/revistas (Revista Veja, Folha de SP, etc) ou artigos eletrônicos para fornecedores (IBM, Microsoft, Oracle, etc).', 'Acadêmico-científico', 'Certificado comprovando a autoria e publicação do artigo.', '2023-07-28 16:31:08'),
(28, 1, 'Doação de sangue', 'Doação de sangue a pessoas específicas ou para o banco de sangue.', 'Social', 'Documento comprovando as atividades (local, data/período) e total de horas.', '2023-07-29 04:50:58'),
(29, 1, 'Cursos extras EaD ou online na ÁREA DO CURSO\r\n', 'Cursos não presenciais - EaD ou ONLINE na ÁREA DO CURSO. Estes cursos podem ser realizados em qualquer plataforma (exemplo Udemy, Alura, dentre outros). Por exemplo, podem ser cursos solicitados nas disciplinas pelos professores, desde que na área do curso.', 'Acadêmico-científico', 'Certificado de conclusão informando a instituição ou empresa, período e carga horária.', '2023-07-29 04:58:25');

-- --------------------------------------------------------

--
-- Table structure for table `atvd_feita`
--

CREATE TABLE `atvd_feita` (
  `cod_atvd_feita` int(11) NOT NULL,
  `cod_atvd` smallint(6) NOT NULL,
  `cod_aluno` mediumint(9) NOT NULL,
  `cod_disc` smallint(6) NOT NULL,
  `cod_arquivo` int(11) NOT NULL,
  `cod_relatorio` mediumint(9) DEFAULT NULL,
  `descricao_atvd` varchar(600) NOT NULL,
  `data_atvd` date NOT NULL,
  `qntd_horas` tinyint(3) UNSIGNED NOT NULL,
  `horas_validas` tinyint(4) NOT NULL,
  `status_envio` tinyint(1) NOT NULL DEFAULT 0,
  `status_avaliacao` tinyint(1) NOT NULL DEFAULT 0,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT 0,
  `data_criacao` date NOT NULL,
  `data_envio` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atvd_feita`
--

INSERT INTO `atvd_feita` (`cod_atvd_feita`, `cod_atvd`, `cod_aluno`, `cod_disc`, `cod_arquivo`, `cod_relatorio`, `descricao_atvd`, `data_atvd`, `qntd_horas`, `horas_validas`, `status_envio`, `status_avaliacao`, `status_arquivamento`, `data_criacao`, `data_envio`) VALUES
(1, 29, 44, 1, 1, 1, 'Curso EAD - Introdução à gestão de projetos', '2021-08-10', 10, 10, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(2, 29, 44, 1, 2, 1, 'Curso EAD - Introdução a criação de websites com HTML5 e CSS3.', '2021-09-27', 6, 6, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(3, 29, 44, 1, 3, 1, 'Curso EAD - Lógica de Programação Essencial.', '2021-09-24', 4, 4, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(4, 29, 44, 1, 4, 1, 'Curso EAD - Instalando o Visual Studio e SDK.', '2021-09-28', 1, 1, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(5, 29, 44, 1, 5, 1, 'Curso EAD - Linux: A introdução ao sistema operacional.', '2021-09-29', 10, 10, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(6, 26, 44, 1, 6, 1, 'Live – Profissional e Profissões do Futuro: como preparar sua carreira para 2031.', '2021-08-31', 1, 1, 1, 1, 0, '2023-08-11', '2023-08-11 02:15:39'),
(7, 28, 44, 1, 7, 1, 'Doação de Sangue', '2021-11-25', 8, 5, 1, 0, 0, '2023-08-11', '2023-08-11 02:15:39');

--
-- Triggers `atvd_feita`
--
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_atvd_feita` BEFORE INSERT ON `atvd_feita` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `atvd_por_curso`
--

CREATE TABLE `atvd_por_curso` (
  `cod_atvd` smallint(6) NOT NULL,
  `cod_curso` tinyint(4) NOT NULL,
  `carga_horaria_max` tinyint(3) UNSIGNED NOT NULL,
  `limite_horas_atvd` tinyint(3) UNSIGNED NOT NULL,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT 0,
  `data_arquivamento` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `atvd_por_curso`
--

INSERT INTO `atvd_por_curso` (`cod_atvd`, `cod_curso`, `carga_horaria_max`, `limite_horas_atvd`, `status_arquivamento`, `data_arquivamento`) VALUES
(23, 1, 20, 10, 0, NULL),
(23, 2, 20, 10, 0, NULL),
(24, 1, 20, 20, 0, NULL),
(26, 1, 15, 3, 0, NULL),
(26, 2, 15, 3, 0, NULL),
(27, 1, 20, 10, 0, NULL),
(28, 1, 5, 5, 0, NULL),
(29, 1, 30, 10, 0, NULL),
(29, 2, 30, 10, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `conceito`
--

CREATE TABLE `conceito` (
  `cod_conceito` mediumint(9) NOT NULL,
  `cod_relatorio` mediumint(9) NOT NULL,
  `cod_professor` mediumint(9) NOT NULL,
  `cod_disc` smallint(6) NOT NULL,
  `cod_aluno` mediumint(9) NOT NULL,
  `conceito` tinyint(1) NOT NULL,
  `data_criacao` date NOT NULL,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `conceito`
--
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_conceito` BEFORE INSERT ON `conceito` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

CREATE TABLE `curso` (
  `cod_curso` tinyint(4) NOT NULL,
  `nome_curso` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curso`
--

INSERT INTO `curso` (`cod_curso`, `nome_curso`) VALUES
(1, 'GTI'),
(2, 'G3E');

-- --------------------------------------------------------

--
-- Table structure for table `disciplina`
--

CREATE TABLE `disciplina` (
  `cod_disc` smallint(6) NOT NULL,
  `nome_disc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disciplina`
--

INSERT INTO `disciplina` (`cod_disc`, `nome_disc`) VALUES
(1, 'TAA001'),
(2, 'TAA002');

-- --------------------------------------------------------

--
-- Table structure for table `disc_matriculada`
--

CREATE TABLE `disc_matriculada` (
  `cod_aluno` mediumint(9) NOT NULL,
  `cod_disc` smallint(6) NOT NULL,
  `status_matricula` tinyint(1) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disc_matriculada`
--

INSERT INTO `disc_matriculada` (`cod_aluno`, `cod_disc`, `status_matricula`, `data_criacao`) VALUES
(32, 1, 1, '2023-07-24 00:33:05'),
(41, 1, 1, '2023-07-25 18:45:15'),
(42, 1, 1, '2023-07-25 18:46:26'),
(43, 1, 1, '2023-07-28 05:38:01'),
(44, 1, 1, '2023-07-28 17:22:12'),
(45, 1, 1, '2023-08-02 19:58:53'),
(32, 2, 1, '2023-07-24 00:33:05'),
(41, 2, 1, '2023-07-25 18:45:15'),
(42, 2, 0, '2023-07-25 18:46:26'),
(43, 2, 1, '2023-07-28 05:38:01'),
(44, 2, 1, '2023-07-28 17:22:12'),
(45, 2, 1, '2023-08-02 19:58:53');

-- --------------------------------------------------------

--
-- Table structure for table `disc_por_curso`
--

CREATE TABLE `disc_por_curso` (
  `cod_disc_por_curso` smallint(6) NOT NULL,
  `cod_disc` smallint(6) NOT NULL,
  `cod_curso` tinyint(4) NOT NULL,
  `nome_curso` varchar(30) NOT NULL,
  `nome_disc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disc_por_curso`
--

INSERT INTO `disc_por_curso` (`cod_disc_por_curso`, `cod_disc`, `cod_curso`, `nome_curso`, `nome_disc`) VALUES
(1, 1, 1, 'GTI', 'TAA001'),
(2, 2, 1, 'GTI', 'TAA002'),
(3, 1, 2, 'G3E', 'TAA001'),
(4, 2, 2, 'G3E', 'TAA002');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `cod_feedback` int(11) NOT NULL,
  `cod_atvd_feita` int(11) NOT NULL,
  `cod_professor` mediumint(9) NOT NULL,
  `feedback` tinyint(1) NOT NULL,
  `descricao_feedback` varchar(1000) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`cod_feedback`, `cod_atvd_feita`, `cod_professor`, `feedback`, `descricao_feedback`, `data_criacao`) VALUES
(4, 1, 1, 1, 'Atividade ok', '2023-08-11 14:58:07'),
(5, 2, 1, 1, 'aprovada', '2023-08-11 15:07:31'),
(6, 3, 1, 0, 'anexo inválido', '2023-08-11 15:07:53'),
(7, 4, 1, 1, 'Atividade ok.', '2023-08-11 15:08:23'),
(8, 5, 1, 1, 'Atividade ok.', '2023-08-11 15:13:41'),
(9, 6, 1, 1, 'Atividade ok.', '2023-08-11 15:16:26'),
(10, 1, 1, 1, 'AAA', '2023-08-11 18:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `prazo`
--

CREATE TABLE `prazo` (
  `cod_prazo` tinyint(1) NOT NULL DEFAULT 1,
  `inicio_entrega` date DEFAULT NULL,
  `entrega_um` date DEFAULT NULL,
  `entrega_final` date DEFAULT NULL,
  `fim_semestre` date DEFAULT NULL,
  `inicio_semestre` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prazo`
--

INSERT INTO `prazo` (`cod_prazo`, `inicio_entrega`, `entrega_um`, `entrega_final`, `fim_semestre`, `inicio_semestre`) VALUES
(1, '2023-09-02', '2023-11-01', '2023-12-01', '2023-12-30', '2024-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `cod_professor` mediumint(9) NOT NULL,
  `cod_usuario` mediumint(9) NOT NULL,
  `cod_curso` tinyint(4) NOT NULL,
  `cpf` char(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL,
  `email_professor` varchar(60) NOT NULL,
  `data_nascimento` date NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`cod_professor`, `cod_usuario`, `cod_curso`, `cpf`, `nome`, `sobrenome`, `genero`, `email_professor`, `data_nascimento`, `data_criacao`) VALUES
(1, 6, 1, '00000000001', 'Silvia', 'Farani', 'Mulher', 'a', '2023-07-29', '2023-07-06 18:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `regulamento`
--

CREATE TABLE `regulamento` (
  `cod_regulamento` smallint(6) NOT NULL,
  `cod_arquivo` int(11) NOT NULL,
  `cod_professor` mediumint(9) NOT NULL,
  `data_regulamento` date NOT NULL,
  `ciclo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relatorio`
--

CREATE TABLE `relatorio` (
  `cod_relatorio` mediumint(9) NOT NULL,
  `cod_aluno` mediumint(9) NOT NULL,
  `cod_disc` smallint(6) NOT NULL,
  `semestre` tinyint(3) UNSIGNED NOT NULL,
  `horas_enviadas` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `horas_validadas` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `horas_coringa` tinyint(3) UNSIGNED DEFAULT NULL,
  `status_validacao` tinyint(1) NOT NULL DEFAULT 0,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT 0,
  `status_envio` tinyint(1) NOT NULL DEFAULT 0,
  `status_recebimento` tinyint(1) NOT NULL DEFAULT 0,
  `data_criacao` date NOT NULL,
  `data_envio` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relatorio`
--

INSERT INTO `relatorio` (`cod_relatorio`, `cod_aluno`, `cod_disc`, `semestre`, `horas_enviadas`, `horas_validadas`, `horas_coringa`, `status_validacao`, `status_arquivamento`, `status_envio`, `status_recebimento`, `data_criacao`, `data_envio`) VALUES
(1, 44, 1, 6, 40, 0, NULL, 0, 0, 1, 0, '2023-08-11', '2023-08-11 02:15:39');

--
-- Triggers `relatorio`
--
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_relatorio` BEFORE INSERT ON `relatorio` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `cod_usuario` mediumint(9) NOT NULL,
  `foto_perfil_cod_arquivo` int(11) DEFAULT NULL,
  `senha` varchar(18) NOT NULL,
  `status_usuario` tinyint(1) NOT NULL DEFAULT 1,
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT 1,
  `perfil` enum('ADM','Professor','Aluno') NOT NULL DEFAULT 'Aluno',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `foto_perfil_cod_arquivo`, `senha`, `status_usuario`, `primeiro_acesso`, `perfil`, `data_criacao`) VALUES
(2, NULL, '1234', 1, 1, 'ADM', '2023-07-06 16:51:12'),
(6, NULL, '1234', 1, 0, 'Professor', '2023-07-06 18:26:14'),
(44, NULL, '2003-03-17', 1, 0, 'Aluno', '2023-07-24 00:33:05'),
(48, NULL, '2001-04-19', 1, 1, 'Aluno', '2023-07-25 18:43:52'),
(49, NULL, '2003-12-08', 1, 1, 'Aluno', '2023-07-25 18:45:15'),
(50, NULL, '2009-09-16', 1, 1, 'Aluno', '2023-07-25 18:46:26'),
(51, NULL, '2000-06-14', 1, 1, 'Aluno', '2023-07-28 05:38:01'),
(52, NULL, '2001-04-19', 1, 0, 'Aluno', '2023-07-28 17:22:12'),
(53, NULL, 'pipoca123', 1, 0, 'Aluno', '2023-08-02 19:58:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`cod_adm`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`cod_aluno`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `ra` (`ra`),
  ADD KEY `cod_curso` (`cod_curso`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`cod_arquivo`),
  ADD KEY `cod_usuario` (`cod_usuario`);

--
-- Indexes for table `atvd_a_fazer`
--
ALTER TABLE `atvd_a_fazer`
  ADD PRIMARY KEY (`cod_atvd`),
  ADD UNIQUE KEY `tipo_atvd` (`tipo_atvd`),
  ADD KEY `cod_professor` (`cod_professor`);

--
-- Indexes for table `atvd_feita`
--
ALTER TABLE `atvd_feita`
  ADD PRIMARY KEY (`cod_atvd_feita`),
  ADD KEY `cod_atvd` (`cod_atvd`),
  ADD KEY `cod_arquivo_atvd_feita` (`cod_arquivo`),
  ADD KEY `cod_relatorio_atvd_feita` (`cod_relatorio`),
  ADD KEY `atvd_feita_ibfk_3` (`cod_aluno`),
  ADD KEY `cod_disc` (`cod_disc`);

--
-- Indexes for table `atvd_por_curso`
--
ALTER TABLE `atvd_por_curso`
  ADD PRIMARY KEY (`cod_atvd`,`cod_curso`),
  ADD KEY `cod_curso` (`cod_curso`),
  ADD KEY `cod_atvd` (`cod_atvd`);

--
-- Indexes for table `conceito`
--
ALTER TABLE `conceito`
  ADD PRIMARY KEY (`cod_conceito`),
  ADD KEY `cod_relatorio` (`cod_relatorio`),
  ADD KEY `cod_professor` (`cod_professor`),
  ADD KEY `disc_matriculada_conceito` (`cod_aluno`,`cod_disc`);

--
-- Indexes for table `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`cod_curso`);

--
-- Indexes for table `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`cod_disc`);

--
-- Indexes for table `disc_matriculada`
--
ALTER TABLE `disc_matriculada`
  ADD PRIMARY KEY (`cod_disc`,`cod_aluno`),
  ADD KEY `cod_aluno` (`cod_aluno`),
  ADD KEY `cod_disc` (`cod_disc`);

--
-- Indexes for table `disc_por_curso`
--
ALTER TABLE `disc_por_curso`
  ADD PRIMARY KEY (`cod_disc_por_curso`),
  ADD KEY `cod_curso` (`cod_curso`),
  ADD KEY `cod_disc` (`cod_disc`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`cod_feedback`),
  ADD KEY `cod_professor` (`cod_professor`),
  ADD KEY `cod_atvd_feita_feedback` (`cod_atvd_feita`);

--
-- Indexes for table `prazo`
--
ALTER TABLE `prazo`
  ADD PRIMARY KEY (`cod_prazo`);

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`cod_professor`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `cod_usuario` (`cod_usuario`),
  ADD KEY `cod_curso` (`cod_curso`);

--
-- Indexes for table `regulamento`
--
ALTER TABLE `regulamento`
  ADD PRIMARY KEY (`cod_regulamento`),
  ADD KEY `cod_arquivo` (`cod_arquivo`),
  ADD KEY `cod_professor` (`cod_professor`);

--
-- Indexes for table `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`cod_relatorio`),
  ADD KEY `cod_disc_matriculada_rel` (`cod_aluno`,`cod_disc`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD KEY `foto_perfil_usuario` (`foto_perfil_cod_arquivo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adm`
--
ALTER TABLE `adm`
  MODIFY `cod_adm` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `cod_aluno` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `cod_arquivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `atvd_a_fazer`
--
ALTER TABLE `atvd_a_fazer`
  MODIFY `cod_atvd` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `atvd_feita`
--
ALTER TABLE `atvd_feita`
  MODIFY `cod_atvd_feita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `conceito`
--
ALTER TABLE `conceito`
  MODIFY `cod_conceito` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `curso`
--
ALTER TABLE `curso`
  MODIFY `cod_curso` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `cod_disc` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `disc_por_curso`
--
ALTER TABLE `disc_por_curso`
  MODIFY `cod_disc_por_curso` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `cod_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `cod_professor` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `regulamento`
--
ALTER TABLE `regulamento`
  MODIFY `cod_regulamento` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `cod_relatorio` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `cod_usuario` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adm`
--
ALTER TABLE `adm`
  ADD CONSTRAINT `adm_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`);

--
-- Constraints for table `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`cod_curso`) REFERENCES `curso` (`cod_curso`),
  ADD CONSTRAINT `aluno_ibfk_2` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`);

--
-- Constraints for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `arquivos_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`);

--
-- Constraints for table `atvd_a_fazer`
--
ALTER TABLE `atvd_a_fazer`
  ADD CONSTRAINT `atvd_a_fazer_ibfk_1` FOREIGN KEY (`cod_professor`) REFERENCES `professor` (`cod_professor`);

--
-- Constraints for table `atvd_feita`
--
ALTER TABLE `atvd_feita`
  ADD CONSTRAINT `atvd_feita_ibfk_1` FOREIGN KEY (`cod_atvd`) REFERENCES `atvd_a_fazer` (`cod_atvd`),
  ADD CONSTRAINT `atvd_feita_ibfk_2` FOREIGN KEY (`cod_aluno`) REFERENCES `aluno` (`cod_aluno`),
  ADD CONSTRAINT `atvd_feita_ibfk_3` FOREIGN KEY (`cod_aluno`) REFERENCES `disc_matriculada` (`cod_aluno`),
  ADD CONSTRAINT `cod_arquivo_atvd_feita` FOREIGN KEY (`cod_arquivo`) REFERENCES `arquivos` (`cod_arquivo`),
  ADD CONSTRAINT `cod_disc` FOREIGN KEY (`cod_disc`) REFERENCES `disciplina` (`cod_disc`),
  ADD CONSTRAINT `cod_relatorio_atvd_feita` FOREIGN KEY (`cod_relatorio`) REFERENCES `relatorio` (`cod_relatorio`);

--
-- Constraints for table `atvd_por_curso`
--
ALTER TABLE `atvd_por_curso`
  ADD CONSTRAINT `atvd_por_curso_ibfk_1` FOREIGN KEY (`cod_atvd`) REFERENCES `atvd_a_fazer` (`cod_atvd`),
  ADD CONSTRAINT `atvd_por_curso_ibfk_2` FOREIGN KEY (`cod_curso`) REFERENCES `curso` (`cod_curso`);

--
-- Constraints for table `conceito`
--
ALTER TABLE `conceito`
  ADD CONSTRAINT `conceito_ibfk_1` FOREIGN KEY (`cod_relatorio`) REFERENCES `relatorio` (`cod_relatorio`),
  ADD CONSTRAINT `conceito_ibfk_2` FOREIGN KEY (`cod_professor`) REFERENCES `professor` (`cod_professor`),
  ADD CONSTRAINT `disc_matriculada_conceito` FOREIGN KEY (`cod_aluno`,`cod_disc`) REFERENCES `disc_matriculada` (`cod_aluno`, `cod_disc`);

--
-- Constraints for table `disc_matriculada`
--
ALTER TABLE `disc_matriculada`
  ADD CONSTRAINT `disc_matriculada_ibfk_1` FOREIGN KEY (`cod_disc`) REFERENCES `disciplina` (`cod_disc`),
  ADD CONSTRAINT `disc_matriculada_ibfk_2` FOREIGN KEY (`cod_aluno`) REFERENCES `aluno` (`cod_aluno`);

--
-- Constraints for table `disc_por_curso`
--
ALTER TABLE `disc_por_curso`
  ADD CONSTRAINT `disc_por_curso_ibfk_1` FOREIGN KEY (`cod_curso`) REFERENCES `curso` (`cod_curso`),
  ADD CONSTRAINT `disc_por_curso_ibfk_2` FOREIGN KEY (`cod_disc`) REFERENCES `disciplina` (`cod_disc`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `cod_atvd_feita_feedback` FOREIGN KEY (`cod_atvd_feita`) REFERENCES `atvd_feita` (`cod_atvd_feita`),
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`cod_professor`) REFERENCES `professor` (`cod_professor`);

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`cod_usuario`),
  ADD CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`cod_curso`) REFERENCES `curso` (`cod_curso`);

--
-- Constraints for table `regulamento`
--
ALTER TABLE `regulamento`
  ADD CONSTRAINT `regulamento_ibfk_1` FOREIGN KEY (`cod_arquivo`) REFERENCES `arquivos` (`cod_arquivo`),
  ADD CONSTRAINT `regulamento_ibfk_2` FOREIGN KEY (`cod_professor`) REFERENCES `professor` (`cod_professor`);

--
-- Constraints for table `relatorio`
--
ALTER TABLE `relatorio`
  ADD CONSTRAINT `cod_disc_matriculada_rel` FOREIGN KEY (`cod_aluno`,`cod_disc`) REFERENCES `disc_matriculada` (`cod_aluno`, `cod_disc`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `foto_perfil_usuario` FOREIGN KEY (`foto_perfil_cod_arquivo`) REFERENCES `arquivos` (`cod_arquivo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
