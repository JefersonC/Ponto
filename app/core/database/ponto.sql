-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Out-2016 às 11:28
-- Versão do servidor: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ponto`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargo`
--

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE IF NOT EXISTS `cargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `cargo`
--

INSERT INTO `cargo` (`id`, `descricao`, `cargaHoraria`) VALUES
(1, 'Administrador', 80);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ponto`
--

DROP TABLE IF EXISTS `ponto`;
CREATE TABLE IF NOT EXISTS `ponto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  `dataAbertura` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dataFechamento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkPontoUsuario_idx` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `ponto`
--

INSERT INTO `ponto` (`id`, `idUsuario`, `estado`, `dataAbertura`, `dataFechamento`) VALUES
(1, 1, 1, '2016-09-10 00:01:40', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `pontofechado`
--
DROP VIEW IF EXISTS `pontofechado`;
CREATE TABLE IF NOT EXISTS `pontofechado` (
`id` bigint(11)
,`dataAbertura` datetime
,`dataFechamento` datetime
,`horas` decimal(44,0)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sistema`
--

DROP TABLE IF EXISTS `sistema`;
CREATE TABLE IF NOT EXISTS `sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versao` double(4,2) NOT NULL DEFAULT '0.00',
  `cargaHoraria` int(11) NOT NULL DEFAULT '160',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `sistema`
--

INSERT INTO `sistema` (`id`, `versao`, `cargaHoraria`) VALUES
(1, 0.10, 160);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(45) COLLATE latin1_general_ci NOT NULL,
  `idCargo` int(11) NOT NULL,
  `identificacao` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `rfid` varchar(16) COLLATE latin1_general_ci DEFAULT NULL,
  `dataCadastro` datetime DEFAULT CURRENT_TIMESTAMP,
  `dataAdmissao` datetime DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxRfid` (`rfid`),
  KEY `fkUsuarioCargo_idx` (`idCargo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `senha`, `nome`, `idCargo`, `identificacao`, `rfid`, `dataCadastro`, `dataAdmissao`, `estado`) VALUES
(1, 'admin@admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure for view `pontofechado`
--
DROP TABLE IF EXISTS `pontofechado`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pontofechado`  AS  (select `id` AS `id`,`dataAbertura` AS `dataAbertura`,`dataFechamento` AS `dataFechamento`,(sum(timestampdiff(MINUTE,`dataAbertura`,`dataFechamento`)) * 60) AS `horas` from `ponto` where (`estado` = 2)) ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `ponto`
--
ALTER TABLE `ponto`
  ADD CONSTRAINT `fkPontoUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `ponto` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fkUsuarioCargo` FOREIGN KEY (`idCargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
