-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 30, 2023 at 05:31 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pea`
--

-- --------------------------------------------------------

--
-- Table structure for table `adm`
--

DROP TABLE IF EXISTS `adm`;
CREATE TABLE IF NOT EXISTS `adm` (
  `cod_adm` tinyint NOT NULL AUTO_INCREMENT,
  `cod_usuario` mediumint NOT NULL,
  `cpf` char(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL DEFAULT 'Não-Binário',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_adm`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `cod_usuario` (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adm`
--

INSERT INTO `adm` (`cod_adm`, `cod_usuario`, `cpf`, `nome`, `sobrenome`, `genero`, `data_criacao`) VALUES
(5, 2, '52456000803', 'Anthony', 'Ramos', 'Homem', '2023-07-07 06:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `cod_aluno` mediumint NOT NULL AUTO_INCREMENT,
  `cod_curso` tinyint NOT NULL,
  `cod_usuario` mediumint NOT NULL,
  `ra` char(13) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL DEFAULT 'Não-Binário',
  `email` varchar(60) NOT NULL,
  `data_nascimento` date NOT NULL,
  `turma` varchar(20) DEFAULT NULL,
  `semestre` tinyint NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_aluno`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `ra` (`ra`),
  KEY `cod_curso` (`cod_curso`),
  KEY `cod_usuario` (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aluno`
--

INSERT INTO `aluno` (`cod_aluno`, `cod_curso`, `cod_usuario`, `ra`, `cpf`, `nome`, `sobrenome`, `genero`, `email`, `data_nascimento`, `turma`, `semestre`, `data_criacao`) VALUES
(32, 1, 44, '2940782113002', '52456000803', 'Anthony', 'Ferreira Ramos', 'Homem', 'nazarick97@gmail.com', '2003-03-17', NULL, 6, '2023-07-24 00:33:05'),
(41, 1, 49, '0987654321123', '00000000002', 'Lili', 'Angulo', 'Não-Binário', 'lili@gmail.com', '2003-12-08', NULL, 1, '2023-07-25 18:45:15'),
(42, 2, 50, '1111111111111', '00000000003', 'Matheus', 'de Souza', 'Não-Binário', 'theuzinho@gmail.com', '2003-05-10', NULL, 3, '2023-07-25 18:46:26'),
(43, 1, 51, '6t54565435434', '32454324543', 'Lucao', '??', 'Não-Binário', 'lucao@gmail.com', '2000-06-14', NULL, 3, '2023-07-28 05:38:01'),
(44, 1, 52, '2940782113055', '49779921800', 'Alessandro', 'Santos Sousa', 'Homem', 'null_ale@gmail.com', '2001-04-19', NULL, 6, '2023-07-28 17:22:12');

--
-- Triggers `aluno`
--
DROP TRIGGER IF EXISTS `tr_inserir_usuario`;
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

DROP TABLE IF EXISTS `arquivos`;
CREATE TABLE IF NOT EXISTS `arquivos` (
  `cod_arquivo` int NOT NULL AUTO_INCREMENT,
  `cod_usuario` mediumint NOT NULL,
  `nome_arquivo_original` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `tipo` enum('image/jpeg','image/png','application/pdf') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tamanho` int NOT NULL,
  `caminho_arquivo` varchar(255) NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_arquivo`),
  KEY `cod_usuario` (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `arquivos`
--

INSERT INTO `arquivos` (`cod_arquivo`, `cod_usuario`, `nome_arquivo_original`, `nome_arquivo`, `tipo`, `tamanho`, `caminho_arquivo`, `data_envio`) VALUES
(20, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49d4255708_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49d4255708_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:01:54'),
(21, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49d6d73017_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49d6d73017_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:02:37'),
(22, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49d924e0ac_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49d924e0ac_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:03:14'),
(23, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49db7b0446_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49db7b0446_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:03:51'),
(24, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49ddd1e8fa_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49ddd1e8fa_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:04:29'),
(25, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49e128c9e4_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49e128c9e4_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:05:22'),
(26, 52, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c49e413816e_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c49e413816e_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-29 05:06:09'),
(34, 52, 'Alessandro Santos de Sousa.pdf', '64c570e20b2ef_Alessandro Santos de Sousa.pdf', 'application/pdf', 1066021, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c570e20b2ef_Alessandro Santos de Sousa.pdf', '2023-07-29 20:04:50'),
(38, 44, '2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '64c5d774e8aa5_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', 'application/pdf', 371151, 'C:/wamp64/www/PEA/arquivos/aluno/atvd_feita/64c5d774e8aa5_2023_1_GTI-FFR-AACC-regulamento geral_revisado_v4.pdf', '2023-07-30 03:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `atvd_a_fazer`
--

DROP TABLE IF EXISTS `atvd_a_fazer`;
CREATE TABLE IF NOT EXISTS `atvd_a_fazer` (
  `cod_atvd` smallint NOT NULL AUTO_INCREMENT,
  `cod_professor` mediumint NOT NULL,
  `tipo_atvd` varchar(100) NOT NULL,
  `descricao_atvd` varchar(500) NOT NULL,
  `categoria_atvd` enum('Acadêmico-científico','Cultural','Social') NOT NULL,
  `tipo_doc_comprobatorio` varchar(200) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_atvd`),
  UNIQUE KEY `tipo_atvd` (`tipo_atvd`),
  KEY `cod_professor` (`cod_professor`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `atvd_feita`;
CREATE TABLE IF NOT EXISTS `atvd_feita` (
  `cod_atvd_feita` int NOT NULL AUTO_INCREMENT,
  `cod_atvd` smallint NOT NULL,
  `cod_aluno` mediumint NOT NULL,
  `cod_disc` smallint NOT NULL,
  `cod_arquivo` int NOT NULL,
  `cod_relatorio` mediumint DEFAULT NULL,
  `descricao_atvd` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_atvd` date NOT NULL,
  `qntd_horas` tinyint UNSIGNED NOT NULL,
  `horas_validas` tinyint NOT NULL,
  `status_envio` tinyint(1) NOT NULL DEFAULT '0',
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT '0',
  `data_criacao` date NOT NULL,
  `data_envio` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cod_atvd_feita`),
  KEY `cod_atvd` (`cod_atvd`),
  KEY `cod_arquivo_atvd_feita` (`cod_arquivo`),
  KEY `cod_relatorio_atvd_feita` (`cod_relatorio`),
  KEY `atvd_feita_ibfk_3` (`cod_aluno`),
  KEY `cod_disc` (`cod_disc`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `atvd_feita`
--

INSERT INTO `atvd_feita` (`cod_atvd_feita`, `cod_atvd`, `cod_aluno`, `cod_disc`, `cod_arquivo`, `cod_relatorio`, `descricao_atvd`, `data_atvd`, `qntd_horas`, `horas_validas`, `status_envio`, `status_arquivamento`, `data_criacao`, `data_envio`) VALUES
(14, 26, 44, 1, 20, 14, 'Curso EAD - Introdução à gestão de projetos ', '2021-08-31', 1, 1, 1, 0, '2023-07-29', NULL),
(15, 29, 44, 1, 21, 14, 'Curso EAD - Introdução a criação de websites com HTML5 e CSS3 ', '2021-09-27', 10, 10, 1, 0, '2023-07-29', NULL),
(16, 29, 44, 1, 22, 14, 'Curso EAD - Lógica de Programação Essencial', '2021-09-24', 4, 4, 1, 0, '2023-07-29', NULL),
(17, 29, 44, 1, 23, 14, 'Curso EAD - Introdução a criação de websites com HTML5 e CSS3', '2021-09-27', 6, 6, 1, 0, '2023-07-29', NULL),
(18, 29, 44, 1, 24, 14, 'Curso EAD - Instalando o Visual Studio e SDK', '2021-09-28', 1, 1, 1, 0, '2023-07-29', NULL),
(19, 29, 44, 1, 25, 14, 'Curso EAD - Linux: A introdução ao sistema operacional', '2021-09-29', 10, 9, 1, 0, '2023-07-29', NULL),
(20, 28, 44, 1, 26, 14, 'Doação de Sangue', '2021-11-25', 8, 5, 1, 0, '2023-07-29', NULL),
(26, 28, 44, 2, 34, 23, 'doei sangue', '2023-07-29', 8, 5, 1, 0, '2023-07-29', NULL),
(27, 29, 32, 1, 38, 13, 'Curso EAD de 15 horas.', '2023-07-30', 15, 10, 0, 0, '2023-07-30', NULL);

--
-- Triggers `atvd_feita`
--
DROP TRIGGER IF EXISTS `tr_default_data_criacao_atvd_feita`;
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_atvd_feita` BEFORE INSERT ON `atvd_feita` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `atvd_por_curso`
--

DROP TABLE IF EXISTS `atvd_por_curso`;
CREATE TABLE IF NOT EXISTS `atvd_por_curso` (
  `cod_atvd` smallint NOT NULL,
  `cod_curso` tinyint NOT NULL,
  `carga_horaria_max` tinyint UNSIGNED NOT NULL,
  `limite_horas_atvd` tinyint UNSIGNED NOT NULL,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT '0',
  `data_arquivamento` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cod_atvd`,`cod_curso`),
  KEY `cod_curso` (`cod_curso`),
  KEY `cod_atvd` (`cod_atvd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `conceito`;
CREATE TABLE IF NOT EXISTS `conceito` (
  `cod_conceito` mediumint NOT NULL AUTO_INCREMENT,
  `cod_relatorio` mediumint NOT NULL,
  `cod_professor` mediumint NOT NULL,
  `conceito` tinyint(1) NOT NULL,
  `data_criacao` date NOT NULL,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cod_conceito`),
  KEY `cod_relatorio` (`cod_relatorio`),
  KEY `cod_professor` (`cod_professor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Triggers `conceito`
--
DROP TRIGGER IF EXISTS `tr_default_data_criacao_conceito`;
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_conceito` BEFORE INSERT ON `conceito` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `cod_curso` tinyint NOT NULL AUTO_INCREMENT,
  `nome_curso` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE IF NOT EXISTS `disciplina` (
  `cod_disc` smallint NOT NULL AUTO_INCREMENT,
  `nome_disc` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_disc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `disc_matriculada`;
CREATE TABLE IF NOT EXISTS `disc_matriculada` (
  `cod_aluno` mediumint NOT NULL,
  `cod_disc` smallint NOT NULL,
  `cod_conceito` mediumint DEFAULT NULL,
  `status_matricula` tinyint(1) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_disc`,`cod_aluno`),
  KEY `cod_aluno` (`cod_aluno`),
  KEY `cod_conceito` (`cod_conceito`),
  KEY `cod_disc` (`cod_disc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `disc_matriculada`
--

INSERT INTO `disc_matriculada` (`cod_aluno`, `cod_disc`, `cod_conceito`, `status_matricula`, `data_criacao`) VALUES
(32, 1, NULL, 1, '2023-07-24 00:33:05'),
(41, 1, NULL, 1, '2023-07-25 18:45:15'),
(42, 1, NULL, 1, '2023-07-25 18:46:26'),
(43, 1, NULL, 1, '2023-07-28 05:38:01'),
(44, 1, NULL, 1, '2023-07-28 17:22:12'),
(32, 2, NULL, 1, '2023-07-24 00:33:05'),
(41, 2, NULL, 1, '2023-07-25 18:45:15'),
(42, 2, NULL, 0, '2023-07-25 18:46:26'),
(43, 2, NULL, 1, '2023-07-28 05:38:01'),
(44, 2, NULL, 1, '2023-07-28 17:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `disc_por_curso`
--

DROP TABLE IF EXISTS `disc_por_curso`;
CREATE TABLE IF NOT EXISTS `disc_por_curso` (
  `cod_disc_por_curso` smallint NOT NULL AUTO_INCREMENT,
  `cod_disc` smallint NOT NULL,
  `cod_curso` tinyint NOT NULL,
  `nome_curso` varchar(30) NOT NULL,
  `nome_disc` varchar(30) NOT NULL,
  PRIMARY KEY (`cod_disc_por_curso`),
  KEY `cod_curso` (`cod_curso`),
  KEY `cod_disc` (`cod_disc`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `cod_feedback` int NOT NULL AUTO_INCREMENT,
  `cod_atvd_feita` int NOT NULL,
  `cod_professor` mediumint NOT NULL,
  `feedback` varchar(1000) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_feedback`),
  KEY `cod_professor` (`cod_professor`),
  KEY `cod_atvd_feita_feedback` (`cod_atvd_feita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prazo`
--

DROP TABLE IF EXISTS `prazo`;
CREATE TABLE IF NOT EXISTS `prazo` (
  `cod_prazo` tinyint(1) NOT NULL DEFAULT '1',
  `inicio_entrega` date DEFAULT NULL,
  `entrega_um` date DEFAULT NULL,
  `entrega_final` date DEFAULT NULL,
  `fim_semestre` date DEFAULT NULL,
  `inicio_semestre` date DEFAULT NULL,
  PRIMARY KEY (`cod_prazo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prazo`
--

INSERT INTO `prazo` (`cod_prazo`, `inicio_entrega`, `entrega_um`, `entrega_final`, `fim_semestre`, `inicio_semestre`) VALUES
(1, '2023-09-02', '2023-11-01', '2023-12-01', '2023-12-30', '2024-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `cod_professor` mediumint NOT NULL AUTO_INCREMENT,
  `cod_usuario` mediumint NOT NULL,
  `cod_curso` tinyint NOT NULL,
  `cpf` char(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(40) NOT NULL,
  `genero` enum('Homem','Mulher','Não-Binário') NOT NULL,
  `email_professor` varchar(60) NOT NULL,
  `data_nascimento` date NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_professor`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `cod_usuario` (`cod_usuario`),
  KEY `cod_curso` (`cod_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`cod_professor`, `cod_usuario`, `cod_curso`, `cpf`, `nome`, `sobrenome`, `genero`, `email_professor`, `data_nascimento`, `data_criacao`) VALUES
(1, 6, 1, '00000000001', 'Silvia', 'Farani', 'Mulher', 'a', '2023-07-29', '2023-07-06 18:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `regulamento`
--

DROP TABLE IF EXISTS `regulamento`;
CREATE TABLE IF NOT EXISTS `regulamento` (
  `cod_regulamento` smallint NOT NULL AUTO_INCREMENT,
  `cod_arquivo` int NOT NULL,
  `cod_professor` mediumint NOT NULL,
  `data_regulamento` date NOT NULL,
  `ciclo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod_regulamento`),
  KEY `cod_arquivo` (`cod_arquivo`),
  KEY `cod_professor` (`cod_professor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `relatorio`
--

DROP TABLE IF EXISTS `relatorio`;
CREATE TABLE IF NOT EXISTS `relatorio` (
  `cod_relatorio` mediumint NOT NULL AUTO_INCREMENT,
  `cod_aluno` mediumint NOT NULL,
  `cod_disc` smallint NOT NULL,
  `horas_validadas` tinyint UNSIGNED NOT NULL,
  `horas_coringa` tinyint UNSIGNED DEFAULT NULL,
  `status_arquivamento` tinyint(1) NOT NULL DEFAULT '0',
  `status_envio` tinyint(1) NOT NULL DEFAULT '0',
  `data_criacao` date NOT NULL,
  `data_envio` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`cod_relatorio`),
  KEY `cod_disc_rel` (`cod_disc`),
  KEY `cod_disc_matriculada_rel` (`cod_aluno`,`cod_disc`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `relatorio`
--

INSERT INTO `relatorio` (`cod_relatorio`, `cod_aluno`, `cod_disc`, `horas_validadas`, `horas_coringa`, `status_arquivamento`, `status_envio`, `data_criacao`, `data_envio`) VALUES
(13, 32, 1, 0, 0, 0, 0, '2023-07-28', NULL),
(14, 44, 1, 0, 0, 0, 0, '2023-07-29', NULL),
(23, 44, 2, 0, 0, 0, 0, '2023-07-29', NULL);

--
-- Triggers `relatorio`
--
DROP TRIGGER IF EXISTS `tr_default_data_criacao_relatorio`;
DELIMITER $$
CREATE TRIGGER `tr_default_data_criacao_relatorio` BEFORE INSERT ON `relatorio` FOR EACH ROW SET NEW.data_criacao = CURDATE()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `cod_usuario` mediumint NOT NULL AUTO_INCREMENT,
  `senha` varchar(18) NOT NULL,
  `status_usuario` tinyint(1) NOT NULL DEFAULT '1',
  `primeiro_acesso` tinyint(1) NOT NULL DEFAULT '1',
  `perfil` enum('ADM','Professor','Aluno') NOT NULL DEFAULT 'Aluno',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `senha`, `status_usuario`, `primeiro_acesso`, `perfil`, `data_criacao`) VALUES
(2, '1234', 1, 1, 'ADM', '2023-07-06 16:51:12'),
(6, '1234', 1, 1, 'Professor', '2023-07-06 18:26:14'),
(44, '2003-03-17', 1, 1, 'Aluno', '2023-07-24 00:33:05'),
(48, '2001-04-19', 1, 1, 'Aluno', '2023-07-25 18:43:52'),
(49, '2003-12-08', 1, 1, 'Aluno', '2023-07-25 18:45:15'),
(50, '2003-05-10', 1, 1, 'Aluno', '2023-07-25 18:46:26'),
(51, '2000-06-14', 1, 1, 'Aluno', '2023-07-28 05:38:01'),
(52, '2001-04-19', 1, 1, 'Aluno', '2023-07-28 17:22:12');

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
  ADD CONSTRAINT `atvd_feita_ibfk_3` FOREIGN KEY (`cod_aluno`) REFERENCES `disc_matriculada` (`cod_aluno`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cod_arquivo_atvd_feita` FOREIGN KEY (`cod_arquivo`) REFERENCES `arquivos` (`cod_arquivo`),
  ADD CONSTRAINT `cod_disc` FOREIGN KEY (`cod_disc`) REFERENCES `disciplina` (`cod_disc`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cod_relatorio_atvd_feita` FOREIGN KEY (`cod_relatorio`) REFERENCES `relatorio` (`cod_relatorio`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `conceito_ibfk_2` FOREIGN KEY (`cod_professor`) REFERENCES `professor` (`cod_professor`);

--
-- Constraints for table `disc_matriculada`
--
ALTER TABLE `disc_matriculada`
  ADD CONSTRAINT `cod_conceito` FOREIGN KEY (`cod_conceito`) REFERENCES `conceito` (`cod_conceito`),
  ADD CONSTRAINT `disc_matriculada_ibfk_2` FOREIGN KEY (`cod_aluno`) REFERENCES `aluno` (`cod_aluno`),
  ADD CONSTRAINT `disc_matriculada_ibfk_3` FOREIGN KEY (`cod_disc`) REFERENCES `disciplina` (`cod_disc`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `cod_disc_matriculada_rel` FOREIGN KEY (`cod_aluno`,`cod_disc`) REFERENCES `disc_matriculada` (`cod_aluno`, `cod_disc`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
