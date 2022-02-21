CREATE DATABASE  IF NOT EXISTS `cryptobot` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cryptobot`;

DROP TABLE IF EXISTS `bot1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bot1` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `wallet` float DEFAULT NULL,
  PRIMARY KEY (`id`)


DROP TABLE IF EXISTS `orderBook1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderBook1` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `symbol` varchar(45) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
