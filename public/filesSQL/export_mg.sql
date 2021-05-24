-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: magasin
-- ------------------------------------------------------
-- Server version	8.0.18

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `annee`
--

DROP TABLE IF EXISTS `annee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `annee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libele_an` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courante` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `annee`
--

LOCK TABLES `annee` WRITE;
/*!40000 ALTER TABLE `annee` DISABLE KEYS */;
INSERT INTO `annee` VALUES (1,'2021',1);
/*!40000 ALTER TABLE `annee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `libele` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qte_min` int(11) NOT NULL,
  `qte_ini` int(11) NOT NULL,
  `remarque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66BCF5E72D` (`categorie_id`),
  KEY `IDX_23A0E66C54C8C93` (`type_id`),
  KEY `IDX_23A0E66A76ED395` (`user_id`),
  CONSTRAINT `FK_23A0E66A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_23A0E66BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  CONSTRAINT `FK_23A0E66C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,1,1,2,'Bandage',5,10,NULL),(2,5,1,2,'الدفتر الوارد',1,6,NULL),(3,5,1,2,'كراس',10,50,NULL),(4,5,1,2,'كتاب',5,60,NULL),(5,1,1,2,'كرة',9,10,NULL),(6,1,2,2,'tapis',10,10,NULL);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `benificiaire`
--

DROP TABLE IF EXISTS `benificiaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `benificiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fonction_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `benificiaire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_57742B1657889920` (`fonction_id`),
  KEY `IDX_57742B16A76ED395` (`user_id`),
  CONSTRAINT `FK_57742B1657889920` FOREIGN KEY (`fonction_id`) REFERENCES `fonction` (`id`),
  CONSTRAINT `FK_57742B16A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benificiaire`
--

LOCK TABLES `benificiaire` WRITE;
/*!40000 ALTER TABLE `benificiaire` DISABLE KEYS */;
INSERT INTO `benificiaire` VALUES (1,1,2,'adel fourati',NULL),(2,2,2,'aymen mnasri',NULL),(3,3,2,'mohamed jouini',NULL);
/*!40000 ALTER TABLE `benificiaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_497DD634A76ED395` (`user_id`),
  CONSTRAINT `FK_497DD634A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,2,'المعدات الرياضية',NULL),(2,2,'لوازم المخابر',NULL),(3,2,'شراء منظومات',NULL),(4,2,'fournitures informatiques',NULL),(5,2,'fournitures scolaires',NULL);
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `date`
--

DROP TABLE IF EXISTS `date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `date`
--

LOCK TABLES `date` WRITE;
/*!40000 ALTER TABLE `date` DISABLE KEYS */;
/*!40000 ALTER TABLE `date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('App\\Migrations\\Version20210310092315','2021-03-15 10:05:28',108534);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entree`
--

DROP TABLE IF EXISTS `entree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_entree` date NOT NULL,
  `date_bc` date NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_entree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_bc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_598377A6670C757F` (`fournisseur_id`),
  KEY `IDX_598377A6A76ED395` (`user_id`),
  CONSTRAINT `FK_598377A6670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`id`),
  CONSTRAINT `FK_598377A6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entree`
--

LOCK TABLES `entree` WRITE;
/*!40000 ALTER TABLE `entree` DISABLE KEYS */;
INSERT INTO `entree` VALUES (6,1,2,'2021-03-16','2021-03-16','RF11','cc','122'),(7,1,2,'2021-03-17','2021-03-16','ref47','A1','2'),(8,2,2,'2021-05-06','2021-04-30','l4','l4','1'),(9,1,2,'2021-05-08','2021-05-07','RF56','recu1','2');
/*!40000 ALTER TABLE `entree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fonction`
--

DROP TABLE IF EXISTS `fonction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fonction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fonction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarque` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_900D5BDA76ED395` (`user_id`),
  CONSTRAINT `FK_900D5BDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fonction`
--

LOCK TABLES `fonction` WRITE;
/*!40000 ALTER TABLE `fonction` DISABLE KEYS */;
INSERT INTO `fonction` VALUES (1,2,'directeur',NULL),(2,2,'magasinier',NULL),(3,2,'econome',NULL);
/*!40000 ALTER TABLE `fonction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin` int(11) DEFAULT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_369ECA32A76ED395` (`user_id`),
  CONSTRAINT `FK_369ECA32A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fournisseur`
--

LOCK TABLES `fournisseur` WRITE;
/*!40000 ALTER TABLE `fournisseur` DISABLE KEYS */;
INSERT INTO `fournisseur` VALUES (1,2,'mounir soussi',123,'1346882W/A/M/000','12544','15 شارع قرطاج',NULL),(2,2,'Librairie Tunis',NULL,NULL,'445','Sahloul Sousse',NULL);
/*!40000 ALTER TABLE `fournisseur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `num_inv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_338920E0A76ED395` (`user_id`),
  CONSTRAINT `FK_338920E0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventaire`
--

LOCK TABLES `inventaire` WRITE;
/*!40000 ALTER TABLE `inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligne_entree`
--

DROP TABLE IF EXISTS `ligne_entree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ligne_entree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `entree_id` int(11) DEFAULT NULL,
  `qte_entr` int(11) NOT NULL,
  `qte_reste` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7F59EBE07294869C` (`article_id`),
  KEY `IDX_7F59EBE0AF7BD910` (`entree_id`),
  CONSTRAINT `FK_7F59EBE07294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_7F59EBE0AF7BD910` FOREIGN KEY (`entree_id`) REFERENCES `entree` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligne_entree`
--

LOCK TABLES `ligne_entree` WRITE;
/*!40000 ALTER TABLE `ligne_entree` DISABLE KEYS */;
INSERT INTO `ligne_entree` VALUES (11,1,6,20,NULL),(12,6,6,13,NULL),(13,5,6,6,NULL),(14,1,7,8,NULL),(15,6,7,5,NULL),(16,5,7,3,NULL),(17,3,8,15,NULL),(18,4,8,18,NULL),(19,2,8,20,NULL),(20,3,9,20,NULL);
/*!40000 ALTER TABLE `ligne_entree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligne_inventaire`
--

DROP TABLE IF EXISTS `ligne_inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ligne_inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL,
  `inventaire_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `qte_inv` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D025CEFD7294869C` (`article_id`),
  KEY `IDX_D025CEFDCE430A85` (`inventaire_id`),
  KEY `IDX_D025CEFDDCD6110` (`stock_id`),
  CONSTRAINT `FK_D025CEFD7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_D025CEFDCE430A85` FOREIGN KEY (`inventaire_id`) REFERENCES `inventaire` (`id`),
  CONSTRAINT `FK_D025CEFDDCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligne_inventaire`
--

LOCK TABLES `ligne_inventaire` WRITE;
/*!40000 ALTER TABLE `ligne_inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `ligne_inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligne_sortie`
--

DROP TABLE IF EXISTS `ligne_sortie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ligne_sortie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `sortie_id` int(11) DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qte` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1AE54FB47294869C` (`article_id`),
  KEY `IDX_1AE54FB4CC72D953` (`sortie_id`),
  CONSTRAINT `FK_1AE54FB47294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_1AE54FB4CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligne_sortie`
--

LOCK TABLES `ligne_sortie` WRITE;
/*!40000 ALTER TABLE `ligne_sortie` DISABLE KEYS */;
INSERT INTO `ligne_sortie` VALUES (1,1,1,'ref1',8),(2,5,1,'gdgd',9),(3,6,1,'ds1',8),(4,2,2,'DDS',2),(5,3,2,'ch1',10),(6,4,2,'lv2',8),(7,4,3,'tf',3),(8,3,3,'ds1',4),(9,3,4,'y',10),(10,4,4,'DDS',12);
/*!40000 ALTER TABLE `ligne_sortie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ligne_sortie_stock`
--

DROP TABLE IF EXISTS `ligne_sortie_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ligne_sortie_stock` (
  `ligne_sortie_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  PRIMARY KEY (`ligne_sortie_id`,`stock_id`),
  KEY `IDX_6AE6B3AB397D6DB` (`ligne_sortie_id`),
  KEY `IDX_6AE6B3ABDCD6110` (`stock_id`),
  CONSTRAINT `FK_6AE6B3AB397D6DB` FOREIGN KEY (`ligne_sortie_id`) REFERENCES `ligne_sortie` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6AE6B3ABDCD6110` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ligne_sortie_stock`
--

LOCK TABLES `ligne_sortie_stock` WRITE;
/*!40000 ALTER TABLE `ligne_sortie_stock` DISABLE KEYS */;
INSERT INTO `ligne_sortie_stock` VALUES (1,5),(2,7),(3,6),(4,10),(5,8),(6,9),(7,9),(8,8),(9,8),(10,9);
/*!40000 ALTER TABLE `ligne_sortie_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `societe`
--

DROP TABLE IF EXISTS `societe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `societe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nom_soc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ministere` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siege` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `magasinier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `directeur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_19653DBDA76ED395` (`user_id`),
  CONSTRAINT `FK_19653DBDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `societe`
--

LOCK TABLES `societe` WRITE;
/*!40000 ALTER TABLE `societe` DISABLE KEYS */;
INSERT INTO `societe` VALUES (1,2,'المدرسة الاعدادية  ابو القاسم الشابي منوبة','وزارة التربية','المندوبية الجهوية  للتربية بتونس','باردو تونس','تونس','أيمن بن جديرة','رضا الشابي',NULL,NULL);
/*!40000 ALTER TABLE `societe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sortie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annee_id` int(11) DEFAULT NULL,
  `benificiaire_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `bon_sortie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3C3FD3F2543EC5F0` (`annee_id`),
  KEY `IDX_3C3FD3F25FF252E9` (`benificiaire_id`),
  KEY `IDX_3C3FD3F2A76ED395` (`user_id`),
  CONSTRAINT `FK_3C3FD3F2543EC5F0` FOREIGN KEY (`annee_id`) REFERENCES `annee` (`id`),
  CONSTRAINT `FK_3C3FD3F25FF252E9` FOREIGN KEY (`benificiaire_id`) REFERENCES `benificiaire` (`id`),
  CONSTRAINT `FK_3C3FD3F2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sortie`
--

LOCK TABLES `sortie` WRITE;
/*!40000 ALTER TABLE `sortie` DISABLE KEYS */;
INSERT INTO `sortie` VALUES (1,NULL,2,2,'2021-03-16','sort1','1'),(2,1,1,2,'2021-05-06','s4','4'),(3,1,1,2,'2021-05-04','ss','5'),(4,1,1,2,'2021-05-09','xvx','hfhf');
/*!40000 ALTER TABLE `sortie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `ligne_entree_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `qte` int(11) NOT NULL,
  `qte_reste` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4B3656607294869C` (`article_id`),
  KEY `IDX_4B365660609ED698` (`ligne_entree_id`),
  KEY `IDX_4B365660A76ED395` (`user_id`),
  CONSTRAINT `FK_4B365660609ED698` FOREIGN KEY (`ligne_entree_id`) REFERENCES `ligne_entree` (`id`),
  CONSTRAINT `FK_4B3656607294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_4B365660A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (5,1,14,2,'2021-03-16',38,30),(6,6,15,2,'2021-03-16',28,20),(7,5,16,2,'2021-03-16',19,10),(8,3,20,2,'2021-05-09',71,61),(9,4,18,2,'2021-05-09',67,55),(10,2,19,2,'2021-05-06',26,24);
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8CDE5729A76ED395` (`user_id`),
  CONSTRAINT `FK_8CDE5729A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,2,'مواد مستهلكة',NULL),(2,2,'مواد دائمة',NULL);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `societe` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rib` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cin` int(11) DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'x@gmail.com','[\"ROLE_SUPER_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$QjhnbDd4aVoxRktXLzNKUw$geP4Rul8nG5QEyY4ltHBqlxAMUuoWwrF4sTm8ZTu3YA',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'x+1@gmail.com','[\"ROLE_ENTREPRISE\"]','$argon2id$v=19$m=65536,t=4,p=1$Sno3S2p6QlgxakNuWjhGbA$vpWhR/dImHzvfXVcIsc6nUJBLW9YdHWxmONeMEnDtuA',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-17 10:36:03
