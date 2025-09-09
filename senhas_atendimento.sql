-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09/09/2025 às 11:44
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `senhas_atendimento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
CREATE TABLE IF NOT EXISTS `configuracoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_senha` enum('normal','preferencial') NOT NULL,
  `numero_inicial` int NOT NULL,
  `numero_final` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `tipo_senha`, `numero_inicial`, `numero_final`) VALUES
(1, 'normal', 1, 100),
(2, 'preferencial', 1, 100),
(3, 'normal', 1, 100),
(4, 'preferencial', 1, 50),
(5, 'normal', 1, 100),
(6, 'preferencial', 1, 50),
(7, 'normal', 1, 100),
(8, 'preferencial', 1, 50),
(9, 'normal', 1, 100),
(10, 'preferencial', 1, 50),
(11, '', 1, 10);

-- --------------------------------------------------------

--
-- Estrutura para tabela `guiches`
--

DROP TABLE IF EXISTS `guiches`;
CREATE TABLE IF NOT EXISTS `guiches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `guiches`
--

INSERT INTO `guiches` (`id`, `nome`, `status`) VALUES
(18, '2', 1),
(17, '1', 1),
(19, '3', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `senhas`
--

DROP TABLE IF EXISTS `senhas`;
CREATE TABLE IF NOT EXISTS `senhas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(10) DEFAULT NULL,
  `tipo` enum('normal','preferencial') DEFAULT NULL,
  `status` enum('pendente','chamada','atendida') DEFAULT 'pendente',
  `guiche_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `called_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guiche_id` (`guiche_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `senhas_chamadas`
--

DROP TABLE IF EXISTS `senhas_chamadas`;
CREATE TABLE IF NOT EXISTS `senhas_chamadas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_senha` enum('normal','preferencial') NOT NULL,
  `numero_senha` int NOT NULL,
  `guiche_id` int NOT NULL,
  `data_hora` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `guiche_id` (`guiche_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `senhas_chamadas`
--

INSERT INTO `senhas_chamadas` (`id`, `tipo_senha`, `numero_senha`, `guiche_id`, `data_hora`) VALUES
(50, 'normal', 1, 17, '2025-09-08 14:59:03'),
(51, 'normal', 2, 17, '2025-09-08 15:57:20'),
(52, 'preferencial', 1, 17, '2025-09-08 15:57:24'),
(53, 'preferencial', 2, 17, '2025-09-08 17:01:24'),
(54, 'normal', 3, 17, '2025-09-08 17:01:30'),
(55, 'normal', 4, 17, '2025-09-09 08:25:27'),
(56, 'preferencial', 3, 17, '2025-09-09 08:25:33'),
(57, 'preferencial', 4, 17, '2025-09-09 08:25:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel` enum('admin','operador') NOT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `login`, `senha`, `nivel`, `ativo`, `data_criacao`) VALUES
(1, 'Administrador', 'admin', 'admin123', 'admin', 1, '2025-09-09 11:43:15'),
(2, 'Operador 1', 'operador', 'operador123', 'operador', 1, '2025-09-09 11:43:16');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
