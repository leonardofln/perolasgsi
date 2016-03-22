-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2014 at 06:00 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `leotes_teste`
--

-- --------------------------------------------------------

--
-- Table structure for table `est_acesso`
--

CREATE TABLE IF NOT EXISTS `est_acesso` (
  `cdAcesso` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdUsuario` int(10) unsigned DEFAULT NULL,
  `deNome` varchar(255) DEFAULT NULL,
  `deSobrenome` varchar(255) DEFAULT NULL,
  `deEmail` varchar(255) DEFAULT NULL,
  `dtAcesso` datetime NOT NULL,
  `deLink` varchar(1000) NOT NULL,
  `deAcao` varchar(255) NOT NULL,
  `deIp` varchar(20) NOT NULL,
  `deSession` varchar(32) NOT NULL,
  PRIMARY KEY (`cdAcesso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `per_frase`
--

CREATE TABLE IF NOT EXISTS `per_frase` (
  `cdFrase` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deFrase` varchar(1000) NOT NULL,
  `cdUsuario` int(10) unsigned NOT NULL,
  `dtRegistro` datetime NOT NULL,
  PRIMARY KEY (`cdFrase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `per_frase_votacao`
--

CREATE TABLE IF NOT EXISTS `per_frase_votacao` (
  `cdFrase` int(10) unsigned NOT NULL,
  `cdUsuario` int(10) unsigned NOT NULL,
  `flTipo` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`cdFrase`,`cdUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usu_usuario`
--

CREATE TABLE IF NOT EXISTS `usu_usuario` (
  `cdUsuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deNome` varchar(255) NOT NULL,
  `deSobrenome` varchar(255) NOT NULL,
  `deSenha` varchar(32) NOT NULL,
  `deEmail` varchar(255) NOT NULL,
  `cdTipo` int(10) unsigned NOT NULL,
  `deHash` varchar(32) DEFAULT NULL,
  `dtRecuperacao` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cdUsuario`),
  UNIQUE KEY `deEmail` (`deEmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `usu_usuario`
--

INSERT INTO `usu_usuario` (`cdUsuario`, `deNome`, `deSobrenome`, `deSenha`, `deEmail`, `cdTipo`, `deHash`, `dtRecuperacao`) VALUES
(1, 'Administrador', 'da Silva', 'aa1bf4646de67fd9086cf6c79007026c', 'administrador@gmail.com', 2, NULL, NULL),
(2, 'Usuario', 'de Souza', 'aa1bf4646de67fd9086cf6c79007026c', 'usuario@gmail.com', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usu_usuario_tipo`
--

CREATE TABLE IF NOT EXISTS `usu_usuario_tipo` (
  `cdTipo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `deTipo` varchar(255) NOT NULL,
  PRIMARY KEY (`cdTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `usu_usuario_tipo`
--

INSERT INTO `usu_usuario_tipo` (`cdTipo`, `deTipo`) VALUES
(1, 'Usuario'),
(2, 'Administrador');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
