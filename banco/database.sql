CREATE DATABASE  IF NOT EXISTS `fabioalvaro13_dev` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fabioalvaro13_dev`;
-- MySQL dump 10.14  Distrib 5.5.43-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: fabioalvaro13_dev
-- ------------------------------------------------------
-- Server version	5.5.43-MariaDB

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
-- Table structure for table `clifors`
--

DROP TABLE IF EXISTS `clifors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clifors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `doc` varchar(45) NOT NULL,
  `tipodoc` int(11) NOT NULL,
  `tipoclifor` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `ativo` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clifors`
--

LOCK TABLES `clifors` WRITE;
/*!40000 ALTER TABLE `clifors` DISABLE KEYS */;
INSERT INTO `clifors` VALUES (1,'makro atacado','123',1,1,'2016-01-14 19:14:11','2016-01-14 19:14:11',1);
/*!40000 ALTER TABLE `clifors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1249735 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES (1,'diretoria',1),(2,'financeiro',1),(14,'recursos humanos',1),(15,'leo. Morbi neque tellus,',1),(16,'Aliquam rutrum',1),(17,'Cras lorem asd asd ',1),(18,'a',1),(19,'a tortor.',1),(20,'Morbi quis urna. Nunc',1),(21,'Sed diam lorem, auctor',1),(22,'Quisque',1),(23,'sollicitudin adipiscing ligula.',1),(24,'auctor, velit',1),(25,'volutpat. Nulla',1),(26,'augue ac',1),(27,'velit. Cras lorem lorem,',1),(28,'Integer vitae',1),(29,'ut',1),(30,'tempus non, lacinia at,',1),(31,'risus, at fringilla purus',1),(32,'lorem fringilla ornare placerat,',1),(33,'vel, venenatis vel,',1),(34,'Cras dolor',1),(35,'nascetur ridiculus mus.',1),(36,'lacus.',1),(37,'aliquet nec, imperdiet nec,',1),(38,'Curabitur egestas nunc',1),(39,'ipsum dolor sit amet,',1),(40,'id, ante. Nunc',1),(41,'venenatis',1),(42,'Nullam enim.',1),(43,'dictum eu, placerat eget,',1),(44,'in',1),(45,'mauris',1),(46,'nec luctus felis',1),(47,'ac turpis egestas. Aliquam',1),(48,'Nulla tempor augue',1),(49,'Cras sed',1);
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estoques`
--

DROP TABLE IF EXISTS `estoques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estoques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estoques`
--

LOCK TABLES `estoques` WRITE;
/*!40000 ALTER TABLE `estoques` DISABLE KEYS */;
INSERT INTO `estoques` VALUES (1,'Armazem gerais',1),(2,'galpao viracopos',1),(4,'Galpao Rio',1),(5,'aaaa',1),(6,'qweqweqwe',1),(7,'asdasdasd',1),(8,'rtyrtyrty',1),(9,'123123123',1),(10,'asdasdasd',1),(11,'qwe qwe qwe qwe ',1),(12,' qwe qwe qwe ',1),(13,' qwe qwe qwe',1),(14,' qwe qwe qwe',1),(15,' qwe qwe qwe wqe qwe ',1),(16,'qweqwe',1),(17,'Wurtwe ',1),(18,' qwe qwe qwe ',1),(19,'qweqweqweqweqwe',1),(20,'e e e e e e',1),(21,'rrrrrr rrrr r',1),(22,'Zabumba Meu Boi',1),(23,'asda sda sd',1),(24,'Maria Maria Maria',1),(25,'hahahah ',1);
/*!40000 ALTER TABLE `estoques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kardexs`
--

DROP TABLE IF EXISTS `kardexs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kardexs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `tiposmovimento_id` int(11) NOT NULL,
  `clifor_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `estoque_id` int(11) NOT NULL,
  `ativo` int(11) DEFAULT '1',
  `qtd` double DEFAULT '0',
  `sinal` varchar(1) DEFAULT '+',
  PRIMARY KEY (`id`),
  KEY `fk_tiposmovimento_key_idx` (`tiposmovimento_id`),
  CONSTRAINT `fk_tiposmovimento_key` FOREIGN KEY (`tiposmovimento_id`) REFERENCES `tiposmovimentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kardexs`
--

LOCK TABLES `kardexs` WRITE;
/*!40000 ALTER TABLE `kardexs` DISABLE KEYS */;
INSERT INTO `kardexs` VALUES (170,'2016-01-01 00:00:00',1,1,2,1,1,1000,'+'),(172,'2016-01-01 00:00:00',1,1,2,2,1,5000,'+');
/*!40000 ALTER TABLE `kardexs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  `custo` float DEFAULT '0',
  `ativo` time DEFAULT '00:00:01',
  `departamento_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departamento_key_idx` (`departamento_id`),
  CONSTRAINT `fk_produtos_departamento` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (2,'Aluminio Triturado',12,'19:13:00',1),(10,'Macarrao de Chocolate',3,'00:00:01',1),(12,'Coca ssss',3,'00:00:01',1),(13,'Coca rrrrr',3,'00:00:01',1),(14,'Coca ffff',3,'00:00:01',2),(15,'Coca Cola ccccc',3,'00:00:01',2),(16,'Coca Cola asd asd ',3,'00:00:01',2),(25,'Coca Cola qwe qwe qwe ',3,'00:00:01',2),(29,'Coca ',3,'00:00:01',2),(30,'Pepsi',3,'00:00:01',1),(32,'Fanta Uva',9.55,'00:00:01',2),(47,'Latinha marrom 22',22.22,'00:00:01',2),(49,'opa....',2.22,'00:00:01',2);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos_estoques`
--

DROP TABLE IF EXISTS `produtos_estoques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos_estoques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idproduto` int(11) NOT NULL,
  `idestoque` int(11) NOT NULL,
  `qtd` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos_estoques`
--

LOCK TABLES `produtos_estoques` WRITE;
/*!40000 ALTER TABLE `produtos_estoques` DISABLE KEYS */;
INSERT INTO `produtos_estoques` VALUES (18,2,1,1000),(19,2,2,5000);
/*!40000 ALTER TABLE `produtos_estoques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiposmovimentos`
--

DROP TABLE IF EXISTS `tiposmovimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiposmovimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` int(11) DEFAULT '1',
  `sinal` varchar(1) DEFAULT '+',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiposmovimentos`
--

LOCK TABLES `tiposmovimentos` WRITE;
/*!40000 ALTER TABLE `tiposmovimentos` DISABLE KEYS */;
INSERT INTO `tiposmovimentos` VALUES (1,'ENTRADA',1,'+'),(2,'saida',1,'-');
/*!40000 ALTER TABLE `tiposmovimentos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-12  0:24:18
