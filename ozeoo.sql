-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: ozeladiversite
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

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
-- Table structure for table `applicant`
--

DROP TABLE IF EXISTS `applicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personality` longtext COLLATE utf8mb4_unicode_ci,
  `mobility` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CAAD1019A76ED395` (`user_id`),
  CONSTRAINT `FK_CAAD1019A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant`
--

LOCK TABLES `applicant` WRITE;
/*!40000 ALTER TABLE `applicant` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_hard_skills`
--

DROP TABLE IF EXISTS `applicant_hard_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_hard_skills` (
  `applicant_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`applicant_id`,`skill_id`),
  KEY `IDX_949A6BAF97139001` (`applicant_id`),
  KEY `IDX_949A6BAF5585C142` (`skill_id`),
  CONSTRAINT `FK_949A6BAF5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  CONSTRAINT `FK_949A6BAF97139001` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_hard_skills`
--

LOCK TABLES `applicant_hard_skills` WRITE;
/*!40000 ALTER TABLE `applicant_hard_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_hard_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applicant_soft_skills`
--

DROP TABLE IF EXISTS `applicant_soft_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applicant_soft_skills` (
  `applicant_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`applicant_id`,`skill_id`),
  KEY `IDX_8A133AC597139001` (`applicant_id`),
  KEY `IDX_8A133AC55585C142` (`skill_id`),
  CONSTRAINT `FK_8A133AC55585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`),
  CONSTRAINT `FK_8A133AC597139001` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applicant_soft_skills`
--

LOCK TABLES `applicant_soft_skills` WRITE;
/*!40000 ALTER TABLE `applicant_soft_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `applicant_soft_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siret_nb` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ape_nb` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `corporate_culture` longtext COLLATE utf8mb4_unicode_ci,
  `csr` longtext COLLATE utf8mb4_unicode_ci,
  `city` longtext COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4FBF094FA76ED395` (`user_id`),
  CONSTRAINT `FK_4FBF094FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
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
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20201213105003','2021-02-09 19:12:46',635),('DoctrineMigrations\\Version20201213113758','2021-02-09 19:12:47',9),('DoctrineMigrations\\Version20201216155223','2021-02-09 19:12:47',35),('DoctrineMigrations\\Version20201217074800','2021-02-09 19:12:47',11),('DoctrineMigrations\\Version20201217090059','2021-02-09 19:12:47',9),('DoctrineMigrations\\Version20201229131809','2021-02-09 19:12:47',8),('DoctrineMigrations\\Version20201229132020','2021-02-09 19:12:47',11),('DoctrineMigrations\\Version20210105112914','2021-02-09 19:12:47',139),('DoctrineMigrations\\Version20210105181431','2021-02-09 19:12:47',31),('DoctrineMigrations\\Version20210106091533','2021-02-09 19:12:47',169),('DoctrineMigrations\\Version20210106092409','2021-02-09 19:12:47',34),('DoctrineMigrations\\Version20210106152847','2021-02-09 19:12:47',173),('DoctrineMigrations\\Version20210107110052','2021-02-09 19:12:48',40),('DoctrineMigrations\\Version20210107134217','2021-02-09 19:12:48',26),('DoctrineMigrations\\Version20210109161053','2021-02-09 19:12:48',37),('DoctrineMigrations\\Version20210112095448','2021-02-09 19:12:48',13),('DoctrineMigrations\\Version20210118172758','2021-02-09 19:12:48',13),('DoctrineMigrations\\Version20210121085331','2021-02-09 19:12:48',14),('DoctrineMigrations\\Version20210122135030','2021-02-09 19:12:48',43);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer`
--

DROP TABLE IF EXISTS `offer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salary` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `creation_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29D6873E979B1AD6` (`company_id`),
  CONSTRAINT `FK_29D6873E979B1AD6` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer`
--

LOCK TABLES `offer` WRITE;
/*!40000 ALTER TABLE `offer` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_applicant`
--

DROP TABLE IF EXISTS `offer_applicant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_applicant` (
  `offer_id` int NOT NULL,
  `applicant_id` int NOT NULL,
  PRIMARY KEY (`offer_id`,`applicant_id`),
  KEY `IDX_69686DDD53C674EE` (`offer_id`),
  KEY `IDX_69686DDD97139001` (`applicant_id`),
  CONSTRAINT `FK_69686DDD53C674EE` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_69686DDD97139001` FOREIGN KEY (`applicant_id`) REFERENCES `applicant` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_applicant`
--

LOCK TABLES `offer_applicant` WRITE;
/*!40000 ALTER TABLE `offer_applicant` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer_applicant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_hard_skills`
--

DROP TABLE IF EXISTS `offer_hard_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_hard_skills` (
  `offer_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`offer_id`,`skill_id`),
  KEY `IDX_50D7E4E53C674EE` (`offer_id`),
  KEY `IDX_50D7E4E5585C142` (`skill_id`),
  CONSTRAINT `FK_50D7E4E53C674EE` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`id`),
  CONSTRAINT `FK_50D7E4E5585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_hard_skills`
--

LOCK TABLES `offer_hard_skills` WRITE;
/*!40000 ALTER TABLE `offer_hard_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer_hard_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_soft_skills`
--

DROP TABLE IF EXISTS `offer_soft_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_soft_skills` (
  `offer_id` int NOT NULL,
  `skill_id` int NOT NULL,
  PRIMARY KEY (`offer_id`,`skill_id`),
  KEY `IDX_1B842F2453C674EE` (`offer_id`),
  KEY `IDX_1B842F245585C142` (`skill_id`),
  CONSTRAINT `FK_1B842F2453C674EE` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`id`),
  CONSTRAINT `FK_1B842F245585C142` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_soft_skills`
--

LOCK TABLES `offer_soft_skills` WRITE;
/*!40000 ALTER TABLE `offer_soft_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `offer_soft_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill`
--

DROP TABLE IF EXISTS `skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skill` (
  `id` int NOT NULL AUTO_INCREMENT,
  `skill_category_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E3DE477AC58042E` (`skill_category_id`),
  CONSTRAINT `FK_5E3DE477AC58042E` FOREIGN KEY (`skill_category_id`) REFERENCES `skill_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=821 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill`
--

LOCK TABLES `skill` WRITE;
/*!40000 ALTER TABLE `skill` DISABLE KEYS */;
INSERT INTO `skill` VALUES (1,21,'Sens de la coordination et communication en interne'),(2,21,'Capacité à déléguer'),(3,21,'Capacité à responsabiliser les équipes'),(4,21,'Excellente expression écrite'),(5,21,'Fort intérêt pour les nouvelles technologies et médias sociaux'),(6,21,'Respect des règles d\'éthique'),(7,21,'Capacité rédactionnelle'),(8,21,'Don pour anticiper les tendances'),(9,21,'Forte culture du résultat'),(10,21,'Capacité de projection'),(11,21,'Force de conviction'),(12,21,'Savoir animer une équipe'),(13,21,'Sens de la confidentialité'),(14,21,'Curiosité d’esprit'),(15,21,'Capacité de communication'),(16,21,'Esprit de synthèse'),(17,21,'Esprit d\'équipe'),(18,21,'Sens des priorités'),(19,21,'Précision'),(20,21,'Sens du service et du résultat'),(21,21,'Capacité à animer un groupe'),(22,21,'Esprit imaginatif'),(23,21,'Eloquence et audace dans la rédaction'),(24,21,'Capacité à supporter la critique'),(25,21,'Sens du service'),(26,21,'Capacité à concilier autonomie et travail en équipe'),(27,21,'Réactivité'),(28,21,'Capacité à gérer plusieurs dossiers simultanément'),(29,21,'Capacité à analyser ses faiblesses'),(30,21,'Curiosité pour les tendances actuelles'),(31,21,'Aptitude à s’autoformer'),(32,21,'Mémoire visuelle'),(33,21,'Bonne élocution'),(34,21,'Capacité d’improvisation'),(35,21,'Sens pédagogique'),(36,21,'Savoir faire preuve de discrétion'),(37,21,'Avoir une vision stratégique'),(38,21,'Capacité à prendre du recul'),(39,21,'Capacité d’anticipation'),(40,21,'Esprit concret et rationnel'),(41,21,'Capacité à coordonner le travail'),(42,21,'Capacité à avoir un regard à 360°'),(43,21,'Qualités pédagogiques pour répondre aux opérationnels'),(44,21,'Curiosité intellectuelle'),(45,21,'Être pluridisciplinaire'),(46,21,'Rapidité d’exécution'),(47,21,'Intérêt pour l’international'),(48,21,'Sens de l’observation'),(49,21,'Qualités managériales'),(50,21,'Forte culture du résultat'),(51,21,'Savoir gérer au mieux des situations dans l\'urgence'),(52,21,'Goût du challenge'),(53,21,'Capacité à améliorer ses performances'),(54,21,'Persévérance'),(55,21,'Dynamisme'),(56,21,'Sens de l’organisation'),(57,21,'Fiabilité'),(58,21,'Autodiscipline'),(59,21,'Esprit d’équipe virtuel'),(60,21,'Adaptabilité'),(61,21,'Gestion du stress'),(62,21,'A l’aise avec la visioconférence'),(63,21,'Rigueur'),(64,21,'Empathie'),(65,21,'Prise d\'initiative'),(66,21,'Autonome'),(67,21,'Ecoute'),(68,21,'Goût pour la technique et les innovations technologiques'),(69,21,'Bonne expression orale'),(70,21,'Sens de la critique'),(71,21,'Aptitude et passion pour les nouvelles technologies'),(72,21,'Forte personnalité'),(73,21,'Persévérance'),(74,21,'Grande capacité de négociation'),(75,21,'Sens du relationnel'),(76,21,'Goût du challenge'),(77,21,'Diplomatie'),(78,21,'Ponctualité'),(79,21,'Mobilité'),(80,21,'Polyvalence'),(81,21,'Sens de l’argumentation et aptitude à défendre un projet'),(82,21,'Leadership'),(83,21,'Capacité de travail en groupe'),(84,21,'Implication personnelle'),(85,21,'Goût pour la transmission des savoirs'),(86,21,'Sens de l’interprétation'),(87,21,'Bonne réactivité'),(88,21,'Excellente capacité de synthèse'),(89,21,'Force de proposition'),(90,21,'Capacité de communication'),(91,21,'Capacité à présenter des bilans opérationnels'),(92,21,'Capacité d’initiative'),(93,21,'Excellente capacité d’organisation'),(94,21,'Forte culture clients'),(95,21,'Force de persuasion face à la concurrence'),(96,21,'Sens de la négociation'),(97,21,'Ténacité'),(98,21,'Autonomie'),(99,21,'Bonne gestion du stress et de l\'échec'),(100,21,'Capacité à analyser ses atouts'),(101,21,'Capacité à travailler en équipe'),(102,21,'Rigueur'),(103,21,'Bonne capacité rédactionnelle'),(104,21,'Ouverture et curiosité d’esprit '),(105,21,'Force de décision'),(106,21,'Capacité de management'),(107,21,'Capacité de questionnement'),(108,21,'Sens des priorités'),(109,21,'Disponibilité'),(110,21,'Très grande rigueur'),(111,21,'Capacité à atteindre les objectifs qui ont été fixés'),(112,21,'Sens de la relation client'),(113,21,'Bonnes qualités d’encadrement'),(114,21,'Sens des chiffres'),(115,21,'Capacité à travailler en transverse'),(116,21,'Faire preuve de diplomatie'),(117,21,'Capacité à analyser ses faiblesses'),(118,21,'Qualité de gestionnaire'),(119,21,'Pragmatisme'),(120,21,'Sens commercial'),(121,21,'Aisance relationnelle'),(122,21,'Ecoute et compréhension des besoins'),(123,21,'Capacité d\'anticipation'),(124,21,'Créativité et adaptabilité'),(125,21,'Dynamisme'),(126,21,'Esprit d\'entrepreneur'),(127,21,'Goût pour les chiffres'),(128,1,'Connaissance produits/services'),(129,1,'Négociation'),(130,1,'Gestion financière/comptable'),(131,1,'Connaissance du marché'),(132,1,'Connaissance législative'),(133,1,'Connaissance des parties prenantes'),(134,1,'Maitrise des outils informatiques'),(135,1,'Gestion portefeuille client'),(136,1,'Prospection'),(137,1,'Connaissance généraliste en marketing'),(138,1,'Connaissance webmarketing'),(139,1,'Campagne marketing'),(140,1,'Reporting et analyse des données'),(141,1,'Maitrise des langues étrangères'),(142,1,'Maitrise des outils d’analyse statistique'),(143,1,'Maitrise des techniques et canaux de vente'),(144,1,'Connaissance généraliste en communication'),(145,1,'Veille concurrentielle'),(146,1,'Connaissance des techniques de commercialisation'),(147,1,'Connaissance en marketing opérationnel'),(148,1,'Maîtrise des logiciels spécifiques'),(149,1,'Maîtrise des processus produit'),(150,1,'Maîtrise des outils d’analyse du trafic'),(151,1,'Maîtrise des techniques de création'),(152,1,'Maîtrise des outils de création web'),(153,1,'Connaissance des médias sociaux'),(154,1,'Maîtrise des outils de référencement'),(155,1,'Compétences juridiques en matière de contrat, licence, accords'),(156,1,'Maîtrise de la gamme de produit'),(157,1,'Conception d’une offre adaptée'),(158,1,'Maîtrise de la politique commerciale'),(159,1,'Bonne capacité d’évaluation de l’offre et du positionnement'),(160,1,'Connaissance des stratégies de l’entreprise en matière de e-commerce'),(161,1,'Capacité à augmenter la rentabilité et développer le CA'),(162,1,'Augmenter la rentabilité'),(163,1,'Connaissance du secteur d’activité'),(164,1,'Maîtrise des expertises techniques'),(165,1,'Maîtrise des outils de diagnostic'),(166,1,'Connaissance des produits bancaire'),(167,1,'Maîtrise de la législation bancaire'),(168,1,'Maîtrise des réseaux sociaux'),(169,1,'Maîtrise du mix mareking'),(170,1,'Elaborer un plan d’action'),(171,1,'Méthodologie AGILE'),(172,1,'Stratégie de commercialisation digitale'),(173,1,'Législation immobilière'),(174,1,'Législation des marchés'),(175,1,'Gestion de projet'),(176,1,'Gestion des Ressources Humaines'),(177,1,'Choix des prestaires externes'),(178,1,'Maîtrise générale en analyse financière'),(179,1,'Entretenir son réseau'),(180,1,'Gestion des appels d’offres'),(181,1,'Maîtrise générale en merchandising'),(182,1,'Maîtrise des outils de suivi'),(183,1,'Maîtrise générale en web analyse'),(184,1,'Architecture d’un serveur web'),(185,1,'Publicité en ligne'),(186,1,'Création de partenariats'),(187,1,'Maîtrise des outils de conception web'),(188,1,'Maitrise des process commerciaux'),(189,1,'Maitrise des supports de communication'),(190,1,'Veille des évolutions techniques du web'),(191,1,'Maîtrise de la gestion générale du magasin'),(192,1,'Développement général de la marque employeur'),(193,1,'Maitrise des règles de sécurité'),(194,2,'Développement d\'applications'),(195,2,'Veille documentaire'),(196,2,'Concevoir un cahier des charges'),(197,2,'Maitrise des logiciels PAO-CAO'),(198,2,'Maitrise de la législation générale'),(199,2,'Maitrise des méthodes de recherche d\'information'),(200,2,'Maitrise des outils de gestion informatique'),(201,2,'Maitrise des outils informatiques'),(202,2,'RGPD'),(203,2,'Maitrise du langage documentaire'),(204,2,'Maitrise des outils de e-formation'),(205,2,'Management d\'équipe'),(206,2,'Maitrise générale des budgets'),(207,2,'Maitrise des langues étrangères'),(208,2,'Veille technologique'),(209,2,'Entretenir son réseau'),(210,2,'Maitrise des logiciels de production de contenu web'),(211,2,'Maitrise des outils de suivi'),(212,2,'Capacité rédactionnelle'),(213,2,'Maitrise des techniques commerciales'),(214,2,'Maitrise des processus de conception produit'),(215,2,'Connaissance de la législation'),(216,2,'Connaissance de l\'actualité'),(217,2,'Gestion de projet'),(218,2,'Veille concurrentielle'),(219,2,'Logiciels de création de jeux vidéo'),(220,2,'Maitrise des langages de programmation'),(221,2,'Concevoir des illustrations'),(222,2,'Maitrise de la chaîne graphique'),(223,2,'Analyser/réajuster le produit'),(224,2,'Maitrise des logiciels de retouche'),(225,2,'Maitrise des outils de suivis'),(226,2,'Maitrise de la politique d\'archivage'),(227,2,'Maitrise du mix marketing'),(228,2,'Maitrise des techniques de lobbying'),(229,2,'Créer et gérer une planning'),(230,2,'Création d\'évènements on-line'),(231,2,'Travail collaboratif'),(232,2,'Créer un cahier des charges'),(233,2,'Maitrise des langues étrangères'),(234,2,'Promouvoir l\'offre'),(235,2,'Technologies de l\'accessibilité numérique'),(236,2,'Techniques de communication'),(237,2,'Gestion de projet'),(238,2,'Droit de la propriété intellectuelle'),(239,2,'Chaîne graphique'),(240,2,'PAO'),(241,2,'Outils bureautiques'),(242,2,'Connaissances de langues étrangères'),(243,2,'Rédiger le contenu d\'un support de communication'),(244,2,'Concevoir des supports de communication visuelle'),(245,2,'Concevoir un support de communication audiovisuel'),(246,2,'Planifier la réalisation d\'une action de communication'),(247,2,'Vérifier la fiabilité d\'une information'),(248,2,'Développer un réseau de partenaires'),(249,2,'Rédiger un rapport d\'activité'),(250,2,'Concevoir des documents'),(251,2,'Rédiger un communiqué de presse'),(252,2,'Rédiger un discours'),(253,2,'Réaliser un journal interne'),(254,2,'Mener une campagne d\'e-mailing'),(255,2,'Réaliser des supports de communication'),(256,2,'Organiser un évènement'),(257,2,'Organiser une conférence de presse'),(258,2,'Administrer un site web'),(259,2,'Évaluer l\'e-réputation d\'un site web'),(260,2,'Améliorer le positionnement d\'un site web'),(261,2,'Définir une stratégie de communication'),(262,2,'Adapter une campagne de communication à sa cible'),(263,2,'Réaliser le bilan des actions de communication'),(264,2,'Sélectionner le thème d\'une diffusion médiatique'),(265,2,'Traiter des informations recueillies'),(266,2,'Rédiger un article de presse'),(267,2,'Développer un réseau de partenaires'),(268,3,'Maitrise des leviers de financement'),(269,3,'Gestion et planification de projet'),(270,3,'Maitrise de l\'anglais'),(271,3,'Législation liée à son domaine d\'activité'),(272,3,'Connaissance des techniques de négociation'),(273,3,'Déployer une stratégie'),(274,3,'Management d\'équipe'),(275,3,'Maitriser la gestion d\'entreprise'),(276,3,'Connaissance des techniques commerciales'),(277,3,'Déploiement commercial'),(278,3,'Connaissance en marketing'),(279,3,'Gestion du changement'),(280,3,'Veille environnementale'),(281,3,'Entretenir son réseau'),(282,3,'Connaissance des techniques de prospection'),(283,3,'Connaissance des processus d\'innovation'),(284,3,'Développer des partenariats'),(285,4,'Maitrise des logiciels de CAO/DAO'),(286,4,'Manager une équipe'),(287,4,'Maitrise des langues étrangères'),(288,4,'Maitrise de la législation'),(289,4,'Recueillir et analyser des données'),(290,4,'Développer des partenariats'),(291,4,'Gestion de projet'),(292,4,'Connaissance générale de son domaine d\'activité'),(293,4,'Capacité à animer une réunion'),(294,4,'Maitrise des appels d\'offres'),(295,4,'Manager une équipe'),(296,4,'Capacité à piloter l\'avancement d\'un projet'),(297,4,'Maitrise des outils informatiques'),(298,4,'Réaliser un audit d\'avant-projet'),(299,4,'Rédiger un cahier des charges'),(300,4,'Maitrise des techniques de recrutement'),(301,4,'Développer des partenariats auprès des médias'),(302,4,'Développer la marque employeur'),(303,4,'Connaissance des normes de qualité'),(304,4,'Accompagner les collaborateurs'),(305,4,'Elaborer un diagnostic'),(306,4,'Etablir des préconisations'),(307,4,'Maitrise des techniques de formation'),(308,4,'Maitriser les techniques de prévention'),(309,4,'Vérifier la conformité du produit'),(310,4,'Gestion d\'un budget'),(311,4,'Veille technologique'),(312,4,'Déployer une stratégie de communication'),(313,4,'Maitrise des logiciels de calcul'),(314,4,'Maitrise du processus de vente d\'un produit'),(315,4,'Maitrise de la législation'),(316,5,'Connaissance des produits et services bancaires'),(317,5,'Maitrise des techniques d\'analyse financière'),(318,5,'Maitrise de l\'anglais'),(319,5,'Maitrise des différents calculs de coût'),(320,5,'Utilisation des outils bureautiques'),(321,5,'Maitrise des logiciels informatiques'),(322,5,'Maitrise des normes française'),(323,5,'Maitrise des normes internationales'),(324,5,'Réglementation fiscale'),(325,5,'Maîtrise des techniques d\'analyse comptable'),(326,5,'Maitrise des outils de reporting'),(327,5,'Analyse des données collectées'),(328,5,'Maitrise de l\'utilisation des systèmes d\'information'),(329,5,'Connaissance en droit des affaires'),(330,5,'Connaissance en droit des sociétés'),(331,5,'Connaissance en droit des finances'),(332,5,'Connaissance en droit fiscal'),(333,5,'Connaissance des marchés financiers'),(334,5,'Management d\'équipe'),(335,5,'Gestion et pilotage de projet'),(336,5,'Maitrise des techniques de négociations'),(337,5,'Compétences commerciales'),(338,5,'Accompagner le changement'),(339,5,'Créer des partenariats'),(340,5,'Maitrise des normes IFRS'),(341,5,'Maitrise du système global'),(342,5,'Architecture du SI'),(343,5,'Maitrise des bases de données'),(344,5,'Maitrise de l\'anglais technique'),(345,5,'Connaissance des produits et services bancaires'),(346,5,'Maitrise des techniques d\'analyse financière'),(347,5,'Maitrise des différents calculs de coût'),(348,5,'Maitrise des logiciels informatiques'),(349,5,'Utilisation des outils bureautiques'),(350,5,'Accompagner le changement'),(351,5,'Créer des partenariats'),(352,6,'Maitrise du système global'),(353,6,'Architecture du SI'),(354,6,'Maitrise des bases de données'),(355,6,'Maitrise de l\'anglais technique'),(356,6,'Expert dans l\'administration des réseaux'),(357,6,'Expert dans l\'administration du système'),(358,6,'Connaissance des protocoles de communication'),(359,6,'Connaissance des système d\'exploitation'),(360,6,'Maitrise des normes de sécurité'),(361,6,'Maitrise des procédures de sécurité'),(362,6,'Connaissance des logiciels'),(363,6,'Connaissance des normes de fichiers'),(364,6,'Connaissance des systèmes d\'exploitation'),(365,6,'Connaissance des applications'),(366,6,'Connaissance des liaisons inter applications'),(367,6,'Procédures de transmissions de données'),(368,6,'Connaissance de l\'architecture fonctionnelle des SI'),(369,6,'Connaissance de l\'architecture organisationnelle des SI'),(370,6,'Connaissance des langages de programmation spécifiques'),(371,6,'Maitrise des méthodes orientées objet'),(372,6,'Connaissance des outils de tests'),(373,6,'Connaissance des système de gestion de contenu'),(374,6,'Maitrise des systèmes d\'exploitation'),(375,6,'Connaissance des outils de virtualisation'),(376,6,'Connaissance du langage technique'),(377,6,'Maitrise des méthodes orientées objet'),(378,6,'Connaissance des outils de tests'),(379,6,'Connaissance des système de gestion de contenu'),(380,6,'Maitrise des systèmes d\'exploitation'),(381,6,'Connaissance des outils de virtualisation'),(382,6,'Connaissance du langage technique'),(383,6,'Conduite de projet informatique'),(384,6,'Connaissance du web marketing'),(385,6,'Gestion des budgets'),(386,6,'Programmer des algorithmes'),(387,6,'Concevoir des algorithmes'),(388,6,'Réaliser un prototype expérimental'),(389,6,'Corriger les dysfonctionnements'),(390,6,'Définir un protocole de test'),(391,6,'Rédiger un manuel d\'utilisation aux utilisateurs'),(392,6,'Mise en production des produits'),(393,6,'Assurer un SAV'),(394,6,'Connaissance globale des systèmes d\'information'),(395,6,'Notion en contrôle de gestion'),(396,6,'Production industrielle/ Travaux et chantier'),(397,6,'Maitrise des techniques d\'exécution d\'ouvrage'),(398,6,'Gestion de budget'),(399,6,'Audit d\'avant-projet'),(400,6,'Réaliser un chantier dans les délais prévus'),(401,6,'Maitrise des outils informatiques'),(402,6,'Maitrise des logiciels de CAO/DAO'),(403,6,'Connaissance en maitrise d\'oeuvre'),(404,6,'Topographie'),(405,6,'Réglementation en matière de sécurité'),(406,6,'Permis de conduire B,C1,C,C2'),(407,6,'CACES'),(408,6,'Métrage'),(409,6,'Connaissance des normes ISO 9000'),(410,6,'Normes HQE'),(411,6,'ISO 14001'),(412,6,'Suivi et reporting financier'),(413,6,'Maitrise de l\'offre'),(414,6,'Réponse aux appels d\'offre'),(415,6,'Livraison client'),(416,6,'Maitrise des logiciels de gestion'),(417,6,'Planification de projet'),(418,6,'Compétence en management'),(419,6,'Connaissance des codes des marchés'),(420,6,'Logiciels CAO/DAO'),(421,6,'Normes et réglementations'),(422,6,'Langues étrangères'),(423,6,'Relation fournisseurs'),(424,6,'Relation client'),(425,6,'Respect des objectifs de production'),(426,6,'Maitrise des processus spécifique de fabrication'),(427,6,'Techniques d\'amélioration de contenu'),(428,6,'Connaissance en productique'),(429,6,'Connaissance de l\'environnement'),(430,6,'Règles et normes'),(431,6,'Connaissance en économie'),(432,6,'Gestion administrative'),(433,6,'Maitrise des méthodes de développement'),(434,7,'Droit du travail'),(435,7,'Droit social'),(436,7,'Connaissance dispositif réglementaire'),(437,7,'Collecter et analyser les infos'),(438,7,'Maitrise des logiciels RH'),(439,7,'Maitrise des outils bureautiques'),(440,7,'Culture économique'),(441,7,'Connaissance de l\'environnement '),(442,7,'Connaissance des marchés'),(443,7,'Maitrise des techniques d\'entretiens tous canaux'),(444,7,'Langues étrangères'),(445,7,'Maitrise des outils de gestion des CV'),(446,7,'Maitrise du sourcing'),(447,7,'Reporting'),(448,7,'Maitrise de l\'anglais'),(449,7,'Notion en sociologie'),(450,7,'Diversité'),(451,7,'RSE'),(452,7,'Pratique des outils de communication'),(453,7,'Accompagner le salarié '),(454,7,'Notion en psychologie'),(455,7,'Connaissance sécurité et santé'),(456,7,'Connaissance juridique'),(457,7,'Connaissance des éléments environnementaux'),(458,7,'Suivre une stratégie d\'entreprise'),(459,7,'Connaissance des sujets actuels'),(460,7,'Manager et former'),(461,7,'Gérer différents interlocuteurs'),(462,7,'Reporting'),(463,7,'Veille sociale'),(464,7,'Coordoner les équipes'),(465,7,'Législation liée à la paie'),(466,7,'Utiliser les outils de suivi'),(467,7,'Process RH'),(468,7,'Gestion de la diversité'),(469,7,'Animer ses équipes'),(470,7,'Connaissance des Instances Représentatives'),(471,7,'Techniques de négociation'),(472,7,'Maîtrise des SIRH'),(473,7,'Statistiques'),(474,7,'Maitrise de la législation'),(475,7,'Connaissance globale des domaines RH'),(476,7,'Mener à bien une politique RH'),(477,8,'Définir les besoins'),(478,8,'Gestion des appels d\'offres'),(479,8,'Maitriser le processus d\'achat'),(480,8,'Veille réglementaire'),(481,8,'Maitrise de l\'anglais'),(482,8,'Politique d\'achat'),(483,8,'Manager ses équipes'),(484,8,'Maitriser les outils de suivi de performance'),(485,8,'Gestion de projet'),(486,8,'SAV'),(487,8,'Respect du cahier des charges'),(488,8,'Veille environnementale'),(489,8,'Veille concurrentielle'),(490,8,'Etude de marché'),(491,8,'Techniques de prospection'),(492,8,'Accompagner l\'acheteur'),(493,8,'Stratégie d\'achat'),(494,8,'Conformité des produits'),(495,8,'Connaissance de la chaîne logistique'),(496,9,'Sélectionner et préparer l\'engin de manutention'),(497,9,'Décharger des marchandises'),(498,9,'Charger des marchandises'),(499,9,'Déplacer des produits vers la zone de stockage'),(500,9,'Ranger des produits ou marchandises selon leurs dates de validité'),(501,9,'Renseigner les supports de suivi de déplacements des charges'),(502,9,'Transmettre les informations au service concerné'),(503,9,'Vérifier l\'état des charges'),(504,9,'Identifier les anomalies'),(505,9,'Assurer une maintenance de premier niveau'),(506,9,'Contrôler un produit fini'),(507,9,'Approvisionner une ligne de production'),(508,9,'Réaliser une opération logistique'),(509,9,'Conditionner un produit'),(510,9,'Réaliser un inventaire'),(511,9,'Préparer les commandes'),(512,9,'Réceptionner et contrôler des produits'),(513,9,'Gestion des stocks et des approvisionnements'),(514,9,'Logiciels de gestion de stocks'),(515,9,'Caractéristiques de la chaîne logistique'),(516,9,'Règles et consignes de sécurité'),(517,9,'Organisation d\'un site d\'entreposage'),(518,9,'Principes d\'équilibrage des charges'),(519,9,'Techniques d\'inventaire'),(520,9,'Appréciation de charge'),(521,9,'Utilisation de système informatique'),(522,9,'Procédures d\'entretien d\'engins de manutention'),(523,9,'Gestes et postures de manutention'),(524,9,'Utilisation d\'engins de manutention non motorisés (transpalette, diable, ...)'),(525,9,'Techniques de palettisation'),(526,9,'Modalités de chargement/déchargement des marchandises'),(527,10,'Faire un état des éléments à déménager'),(528,10,'signaler les anomalies au client'),(529,10,'Conditionner un produit'),(530,10,'Démonter un équipement'),(531,10,'Sélectionner et charger le matériel de déménagement'),(532,10,'Déménager des charges lourdes'),(533,10,'Ranger les éléments déménagés'),(534,10,'Installer un équipement'),(535,10,'Déballer et ranger des cartons'),(536,10,'Assurer une maintenance'),(537,10,'Réaliser l\'entretien du matériel'),(538,10,'Gestes et postures de manutention'),(539,10,'lecture de plan et schéma'),(540,10,'techniques du conditionnement'),(541,10,'gestes et postures du déménagement'),(542,11,'Réceptionner un produit'),(543,11,'Vérifier la conformité de la livraison'),(544,11,'Réaliser le prélèvement de produits selon les instructions'),(545,11,'Charger des marchandises'),(546,11,'Acheminer des marchandises en zone'),(547,11,'Renseigner les supports de suivi de commande'),(548,11,'Transmettre un état des produits détériorés'),(549,11,'Ranger du matériel'),(550,11,'Mettre à jour une documentation technique'),(551,11,'Nettoyer du matériel ou un équipement'),(552,11,'conditionner un produit'),(553,11,'Réaliser des conditionnements'),(554,11,'Déplacer des produits vers la zone de stockage'),(555,11,'Réglementation sur le stockage de produits spécifiques'),(556,11,'Contrôler la réception des commandes'),(557,11,'Suivre l\'état des stocks'),(558,11,'Proposer un service, produit adapté à la demande client'),(559,11,'Techniques de conditionnement/reconditionnement'),(560,11,'Logiciels de gestion de base de données'),(561,11,'Logiciels de gestion de stocks'),(562,11,'Gestion des stocks et des approvisionnements'),(563,11,'Méthodes de valorisation des stocks'),(564,11,'Préparation d\'une commande'),(565,11,'Lecture de plan de stockage'),(566,11,'Utilisation d\'engins de manutention non motorisés'),(567,11,'Techniques de palettisation'),(568,11,'Règles et consignes de sécurité'),(569,11,'Modalités de stockage'),(570,11,'Gestes et postures de manutention'),(571,11,'Techniques d\'inventaire'),(572,11,'Organisation d\'un site d\'entreposage'),(573,11,'Principes d\'équilibrage des charges'),(574,11,'Utilisation d\'appareils de lecture optique de codes-barres'),(575,12,'Superviser la planification des sites logistiques en fonction de l\'activité'),(576,12,'Superviser l\'activité des équipes logistiques'),(577,12,'Analyser les données d\'activité de la structure'),(578,12,'Analyser les données du service et identifier des axes d\'évolution'),(579,12,'Analyser les coûts de la chaîne logistique'),(580,12,'Organiser et coordonner le circuit des informations'),(581,12,'Suivre un budget'),(582,12,'Concevoir des procédures de gestion'),(583,12,'Contrôler l\'application d\'une réglementation'),(584,12,'Superviser la gestion administrative du personnel'),(585,12,'Mettre en place des actions de gestion de ressources humaines'),(586,12,'Management'),(587,12,'Logiciel d\'Échange de Données Informatisées (EDI)'),(588,12,'Contrôle de gestion'),(589,12,'Gestion administrative'),(590,12,'Gestion comptable'),(591,12,'Normes qualité'),(592,12,'Principes d\'optimisation des coûts'),(593,12,'Règles d\'hygiène et de sécurité'),(594,12,'Modalités de stockage'),(595,12,'Réglementation du transport de marchandises'),(596,12,'Organisation et gestion d\'un site d\'entreposage'),(597,12,'Organisation de la chaîne logistique'),(598,12,'Progiciels spécifiques à la logistique'),(599,12,'Droit commercial'),(600,12,'Législation sociale'),(601,12,'Management de la chaîne logistique'),(602,12,'Outils bureautiques'),(603,12,'Organiser une opération logistique'),(604,12,'Matières dangereuses'),(605,12,'Réglementation du commerce international'),(606,12,'Mettre en place des actions commerciales'),(607,12,'Réaliser un appel d\'offre'),(608,12,'Techniques commerciales'),(609,12,'Traiter des dossiers de contentieux'),(610,12,'Modalités de traitement des litiges'),(611,12,'Définir la stratégie logistique d\'une structure'),(612,13,'Définir des besoins en approvisionnement'),(613,13,'Identifier des fournisseurs, sous-traitants, prestataires'),(614,13,'Réaliser un appel d\'offre'),(615,13,'Établir un cahier des charges'),(616,13,'Analyser une réponse à un appel d\'offres'),(617,13,'Négocier des prix'),(618,13,'Négocier un contrat'),(619,13,'Suivre les conditions d\'exécution d\'un contrat'),(620,13,'Proposer des axes d\'amélioration'),(621,13,'Actualiser des données d\'activité'),(622,13,'Techniques commerciales'),(623,13,'Outils bureautiques'),(624,13,'Audit interne'),(625,13,'Droit commercial'),(626,13,'Code des marchés publics'),(627,13,'Réglementation des douanes'),(628,13,'Procédures d\'appels d\'offres'),(629,14,'Réaliser une gestion comptable'),(630,14,'Accompagner des filiales de groupe dans leur organisation'),(631,14,'Réaliser des actions de communication interne'),(632,14,'Suivre le système d\'information de gestion'),(633,14,'Mettre en place un système d\'information de gestion'),(634,14,'Gestion de l\'information'),(635,14,'Etude prospective'),(636,14,'Concevoir un plan prévisionnel d\'activité'),(637,14,'Conseiller une entreprise en stratégie de développement'),(638,14,'Coordonner l\'activité d\'une équipe'),(639,14,'Diriger un service, une structure'),(640,15,'Superviser les procédures de gestion financière'),(641,15,'Superviser les procédures de gestion administrative'),(642,15,'Élaborer un budget prévisionnel'),(643,15,'Présenter un budget'),(644,15,'Effectuer des ajustements budgétaires'),(645,15,'Suivre l\'évolution des résultats financiers'),(646,15,'Élaborer des recommandations'),(647,15,'Contrôler la gestion de la trésorerie'),(648,15,'Superviser un audit'),(649,15,'Superviser le contrôle de gestion'),(650,15,'Superviser l\'action de conseils juridiques'),(651,15,'Analyse des risques financiers'),(652,15,'Gestion administrative'),(653,15,'Gestion comptable'),(654,15,'Analyse financière'),(655,15,'Réglementation bancaire'),(656,15,'Normes comptables'),(657,15,'Comptabilité'),(658,15,'Fiscalité'),(659,15,'Droit des sociétés'),(660,15,'Comptabilité publique'),(661,15,'Comptabilité analytique'),(662,15,'Audit financier'),(663,15,'Stratégie commerciale'),(664,15,'Stratégie financière'),(665,15,'Droit du travail'),(666,15,'Droit des affaires'),(667,15,'Droit commercial'),(668,15,'Assurer les relations avec des fournisseurs et des prestataires'),(669,15,'Réaliser des actions de négociation'),(670,15,'Traiter des dossiers de contentieux'),(671,15,'Réaliser la gestion des ressources humaines'),(672,15,'GPEC'),(673,15,'Législation sociale'),(674,15,'Gestion des Ressources Humaines'),(675,15,'Mettre en place une politique de recouvrement'),(676,15,'Définir une politique de recouvrement'),(677,15,'Normes qualité'),(678,15,'Définir les besoins en système d\'information'),(679,15,'Outils informatiques'),(680,16,'Analyser les données du secteur de l\'assurance'),(681,16,'Identifier les besoins d\'un client'),(682,16,'Proposer des axes de développement de produits'),(683,16,'Définir la cible'),(684,16,'Concevoir des campagnes publicitaires'),(685,16,'Analyser les résultats des ventes'),(686,16,'Déterminer des mesures corrective'),(687,16,'Évaluer la rentabilité financière'),(688,16,'Définir des objectifs commerciaux'),(689,16,'Définir une stratégie commerciale'),(690,16,'Définir les besoins en assurance d\'un client'),(691,16,'Proposer un service, produit adapté à la demande client'),(692,16,'Développer un portefeuille clients'),(693,16,'Rédiger un contrat d\'assurance'),(694,16,'Traiter l\'information'),(695,16,'Vérifier la conformité d\'une déclaration de sinistre'),(696,16,'Mettre en oeuvre une procédure d\'expertise de sinistre'),(697,16,'Réaliser un appel à cotisation'),(698,16,'Réaliser un suivi des encaissements'),(699,16,'Développer un portefeuille de partenaires'),(700,16,'Expertiser des biens'),(701,16,'Mettre en place des actions commerciales'),(702,16,'Évaluer les responsabilités des parties prenantes'),(703,16,'Outils bureautiques'),(704,16,'Maitrise de l’anglais'),(705,16,'Maitrise de la legislation'),(706,16,'Maitrise des logiciels spécifiques'),(707,16,'Réaliser un suivi financier'),(708,16,'Réaliser un suivi comptable'),(709,17,'Sensibiliser les clients'),(710,17,'Accueillir une clientèle'),(711,17,'Étudier une demande client'),(712,17,'Enregistrer des opérations comptables'),(713,17,'Conseiller un client'),(714,17,'Actualiser les informations'),(715,17,'Classer des documents'),(716,17,'Présenter des produits et services'),(717,17,'Vendre des produits ou services'),(718,17,'Consulter des fichiers clients'),(719,17,'Analyser la situation financière d\'un client'),(720,17,'Définir les besoins d\'un client'),(721,17,'Déterminer une stratégie financière'),(722,17,'Réaliser un suivi des dossiers clients, fournisseurs'),(723,17,'Rédiger des documents de synthèse'),(724,17,'Rédiger un rapport de performance'),(725,17,'Gestion des comptes clients'),(726,17,'Normes rédactionnelles'),(727,17,'Réglementation bancaire'),(728,17,'Procédures de transfert de devises'),(729,17,'Techniques de vente'),(730,17,'Réglementation des produits'),(731,17,'Caractéristiques des produits financiers'),(732,17,'Procédures d\'administration de compte bancaire'),(733,18,'Réglementation de la copropriété'),(734,18,'RGPD'),(735,18,'Veille réglementaire'),(736,18,'Techniques commerciales'),(737,18,'Techniques de vente'),(738,18,'Logiciels spécifiques'),(739,18,'Outils bureautiques'),(740,18,'Prospecter des biens immobiliers'),(741,18,'Prospecter de nouveaux clients'),(742,18,'Définir les besoins d\'un client'),(743,18,'Conseil client'),(744,18,'Évaluer la valeur d\'un bien immobilier'),(745,18,'Actualiser les informations'),(746,18,'Actions de promotion commerciale'),(747,18,'Négocier'),(748,18,'Expertiser des biens immobiliers'),(749,18,'Établir un dossier financier d\'acquisition de biens'),(750,18,'Gestion comptable et administrative'),(751,18,'Renseigner les documents administratifs'),(752,18,'Valoriser un bien immobilier'),(753,18,'Présenter un bien immobilier à un client'),(754,18,'Organiser et planifier la visite de biens'),(755,18,'Évaluer la capacité financière d\'un client'),(756,18,'Réaliser une transaction immobilière'),(757,19,'Procédures d\'encaissement'),(758,19,'Règles de tenue de caisse'),(759,19,'Règles d\'hygiène et de sécurité'),(760,19,'Techniques de mise en rayon'),(761,19,'Utilisation de matériel de nettoyage'),(762,19,'Chaîne du froid'),(763,19,'Logiciels de gestion de stocks'),(764,19,'Techniques d\'inventaire'),(765,19,'Utilisation d\'appareils de lecture optique'),(766,19,'Accueillir les personnes'),(767,19,'Enregistrer la vente d\'un article'),(768,19,'Désactiver l\'antivol d\'un article'),(769,19,'Encaisser le montant d\'une vente'),(770,19,'Proposer un service complémentaire à la vente'),(771,19,'Recueillir l\'avis et les remarques d\'un client'),(772,19,'Réaliser le comptage des fonds de caisses'),(773,19,'Suivre l\'état des stocks'),(774,19,'Définir des besoins en approvisionnement'),(775,19,'Préparer les commandes'),(776,19,'Réceptionner un produit'),(777,19,'Vérifier la conformité de la livraison'),(778,19,'Réceptionner un produit'),(779,19,'Vérifier la conformité de la livraison'),(780,19,'Disposer des produits sur le lieu de vente'),(781,19,'Réaliser le balisage et l\'étiquetage'),(782,19,'Suivre l\'état des stocks'),(783,19,'Définir des besoins en approvisionnement'),(784,19,'Préparer les commandes'),(785,19,'Entretenir un espace de vente'),(786,19,'Contrôler l\'état de conservation d\'un produit '),(787,19,'Organiser un planning du personnel'),(788,19,'Réaliser les transactions monétaires'),(789,19,'Assurer un service après-vente'),(790,19,'Identifier un litige client'),(791,19,'Traiter des litiges clients'),(792,19,'Déterminer des actions correctives'),(793,19,'Contrôler la conformité d\'un équipement ou matériel'),(794,19,'Former du personnel'),(795,20,'Prospecter de nouveaux marchés'),(796,20,'Traiter des dossiers commerciaux'),(797,20,'Sélectionner des fournisseurs, sous-traitants, prestataires'),(798,20,'Décliner la conception générale d\'un projet'),(799,20,'Concevoir une maquette'),(800,20,'Déterminer les modalités de chantier'),(801,20,'Coordonner les différentes phases'),(802,20,'Contrôler l\'état d\'avancement des travaux'),(803,20,'Contrôler les dépenses d\'un chantier'),(804,20,'Contrôler la conformité de réalisation d\'un projet'),(805,20,'Analyser les documents techniques du bâtiment'),(806,20,'Localiser les éléments à contrôler sur un site'),(807,20,'Repérer et identifier des risques'),(808,20,'Réaliser des mesures'),(809,20,'Réaliser un dossier de contrôle technique'),(810,20,'Déterminer des mesures correctives'),(811,20,'Définir un avant-projet'),(812,20,'Déterminer les conditions de réalisation d\'un projet'),(813,20,'Dessiner'),(814,20,'Concevoir un dossier de présentation de projet'),(815,20,'Planifier des opérations de chantier'),(816,20,'Techniques de construction'),(817,20,'Normes de la construction'),(818,20,'Normes de sécurité'),(819,20,'Techniques de métré'),(820,20,'Normes de la construction');
/*!40000 ALTER TABLE `skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skill_category`
--

DROP TABLE IF EXISTS `skill_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skill_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `is_hard` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skill_category`
--

LOCK TABLES `skill_category` WRITE;
/*!40000 ALTER TABLE `skill_category` DISABLE KEYS */;
INSERT INTO `skill_category` VALUES (1,1,'Marketing'),(2,1,'Communication'),(3,1,'Direction d\'entreprise'),(4,1,'Etudes et R&D'),(5,1,'Gestion, finance et administration'),(6,1,'Informatique'),(7,1,'Ressources Humaines'),(8,1,'Services techniques'),(9,1,'Transport et logistique / Manutention / Magasinage'),(10,1,'Déménagement'),(11,1,'Magasinage et préparation de commande'),(12,1,'Direction de site logistique'),(13,1,'Achats'),(14,1,'Contrôle de gestion'),(15,1,'Direction administrative et financière'),(16,1,'Assurance'),(17,1,'Banque'),(18,1,'Immobilier'),(19,1,'Grande distribution'),(20,1,'BTP'),(21,0,'Compétences comportementales');
/*!40000 ALTER TABLE `skill_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@monsite.com','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$DF7tH4xFmnsv9+1FN0EpUA$yTqWtJPrDGGxxHtc5rq/Y5kRr2FArNVKSvQs3yiMYJc',1);
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

-- Dump completed on 2021-02-09 19:23:13
