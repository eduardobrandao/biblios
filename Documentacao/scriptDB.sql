-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: DBBIBLIOS
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.17.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblemprestimo`
--

DROP TABLE IF EXISTS `tblemprestimo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblemprestimo` (
  `idemprestimo` int(11) NOT NULL AUTO_INCREMENT,
  `dtaemprestimo` datetime DEFAULT NULL,
  `dtadevolucao` datetime DEFAULT NULL,
  `idfuncionario` int(11) NOT NULL,
  `bolfinalizado` int(1) NOT NULL,
  PRIMARY KEY (`idemprestimo`),
  KEY `fk_tblemprestimo_tblfuncionario1_idx` (`idfuncionario`),
  CONSTRAINT `fk_tblemprestimo_tblfuncionario1` FOREIGN KEY (`idfuncionario`) REFERENCES `tblfuncionario` (`idfuncionario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemprestimo`
--

LOCK TABLES `tblemprestimo` WRITE;
/*!40000 ALTER TABLE `tblemprestimo` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblemprestimo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblexemplar`
--

DROP TABLE IF EXISTS `tblexemplar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblexemplar` (
  `idexemplar` int(11) NOT NULL AUTO_INCREMENT,
  `strnomeexemplar` varchar(200) NOT NULL,
  `streditora` varchar(200) NOT NULL,
  `idexemplararea` int(11) NOT NULL,
  `strautor` varchar(350) NOT NULL,
  `strpreco` double NOT NULL,
  `dtaano` year(4) DEFAULT NULL,
  `strisbn` varchar(45) NOT NULL,
  `idemprestimo` int(11) DEFAULT NULL,
  `boldisponivel` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idexemplar`),
  KEY `fk_tblexemplar_tblexemplararea1_idx` (`idexemplararea`),
  KEY `fk_tblexemplar_tblemprestimo1_idx` (`idemprestimo`),
  CONSTRAINT `fk_tblexemplar_tblemprestimo1` FOREIGN KEY (`idemprestimo`) REFERENCES `tblemprestimo` (`idemprestimo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tblexemplar_tblexemplararea1` FOREIGN KEY (`idexemplararea`) REFERENCES `tblexemplararea` (`idexemplararea`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblexemplar`
--

LOCK TABLES `tblexemplar` WRITE;
/*!40000 ALTER TABLE `tblexemplar` DISABLE KEYS */;
INSERT INTO `tblexemplar` VALUES (8,'Direito na era digital','sss',1,'Jhosef Blater',170,2010,'AS321',NULL,0),(9,'Direito na era digital','sss',1,'Jhosef Blater',170,2010,'AS321',NULL,0);
/*!40000 ALTER TABLE `tblexemplar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblexemplararea`
--

DROP TABLE IF EXISTS `tblexemplararea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblexemplararea` (
  `idexemplararea` int(11) NOT NULL AUTO_INCREMENT,
  `strnomearea` varchar(200) NOT NULL,
  PRIMARY KEY (`idexemplararea`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblexemplararea`
--

LOCK TABLES `tblexemplararea` WRITE;
/*!40000 ALTER TABLE `tblexemplararea` DISABLE KEYS */;
INSERT INTO `tblexemplararea` VALUES (1,'Direito Criminal'),(2,'Direito Trabalhista');
/*!40000 ALTER TABLE `tblexemplararea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfuncionario`
--

DROP TABLE IF EXISTS `tblfuncionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfuncionario` (
  `idfuncionario` int(11) NOT NULL AUTO_INCREMENT,
  `strnomefuncionario` varchar(250) NOT NULL,
  `strcpf` varchar(11) NOT NULL,
  `dtanascimento` date NOT NULL,
  `stroab` varchar(45) DEFAULT NULL,
  `strtelefone` varchar(11) DEFAULT NULL,
  `idfuncionariotipo` int(11) NOT NULL,
  PRIMARY KEY (`idfuncionario`),
  UNIQUE KEY `strcpf_UNIQUE` (`strcpf`),
  KEY `fk_tblfuncionario_tblfuncionariotipo_idx` (`idfuncionariotipo`),
  CONSTRAINT `fk_tblfuncionario_tblfuncionariotipo` FOREIGN KEY (`idfuncionariotipo`) REFERENCES `tblfuncionariotipo` (`idfuncionariotipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfuncionario`
--

LOCK TABLES `tblfuncionario` WRITE;
/*!40000 ALTER TABLE `tblfuncionario` DISABLE KEYS */;
INSERT INTO `tblfuncionario` VALUES (5,'Francisco Pinto','123','1998-08-25','123456','123456789',2);
/*!40000 ALTER TABLE `tblfuncionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfuncionariotipo`
--

DROP TABLE IF EXISTS `tblfuncionariotipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfuncionariotipo` (
  `idfuncionariotipo` int(11) NOT NULL AUTO_INCREMENT,
  `strnometipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idfuncionariotipo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfuncionariotipo`
--

LOCK TABLES `tblfuncionariotipo` WRITE;
/*!40000 ALTER TABLE `tblfuncionariotipo` DISABLE KEYS */;
INSERT INTO `tblfuncionariotipo` VALUES (1,'Secretario(a)'),(2,'Advogado(a)'),(3,'Estágiario');
/*!40000 ALTER TABLE `tblfuncionariotipo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-11 11:01:32
