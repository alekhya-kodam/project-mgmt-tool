/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.5.27-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: project_list
-- ------------------------------------------------------
-- Server version	10.5.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen_by_admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (8,35,26,'Test','i want one resource to my project','2025-06-18 08:09:21',1),(9,35,26,'Test','I need more time ','2025-06-18 11:17:58',1),(10,35,26,'Test','i want more time\n','2025-06-18 11:18:27',1),(11,36,3,'Manju','Hii','2025-06-26 05:36:11',1),(12,38,3,'Manju','Hello','2025-06-27 11:35:02',1),(13,39,3,'Manju','Hii','2025-06-28 05:18:57',1);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_table`
--

DROP TABLE IF EXISTS `project_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `primary_team_lead` varchar(255) NOT NULL,
  `secondary_team_lead` varchar(255) DEFAULT NULL,
  `tester_name` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `internal_end_date` date DEFAULT NULL,
  `client_end_date` date DEFAULT NULL,
  `technical_skill_stack` text DEFAULT NULL,
  `project_type` varchar(100) DEFAULT NULL,
  `application_type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_table`
--

LOCK TABLES `project_table` WRITE;
/*!40000 ALTER TABLE `project_table` DISABLE KEYS */;
INSERT INTO `project_table` VALUES (9,6,'Prasanna','Poetry Designs','Prasanna','Hemanth','Subhash','2025-05-01','2025-07-30','2025-07-31','Python Api\nReact Ui Material','Client','Web Application'),(10,10,'Sai Krishna','MLM','Sai Krishna','Harish','Ganesh','2025-04-10','2025-07-14','2025-07-15','React+django','Client','Web Application'),(12,12,'Pavani','New Friend\'s Jewellery','Amarendra','Pavani','Sumukh','2025-04-01','2025-05-17','2025-05-17','React, Node js','Client','Web Application'),(13,11,'Hemanth','Landnest','Hemanth','Raju','Naveen','2025-04-01','2025-07-10','2025-07-10','React.js -Frontend,Django -Apis','Client','Mobile Application'),(15,13,'Sai Krushna','RSSM Jewellery Project','Amar','Saikrushna','Sumukh','2025-02-24','2025-05-28','2025-05-30','React','Client','Website'),(16,20,'Soujanya','Aayush','Bhargav','Soujanya','Amarendra, Priya','2024-11-28','2024-12-31','2025-01-01','PHP','Client','Desktop Application'),(17,16,'Bharath','Xecutables','Bhargav','Priya','Bharath','2024-09-10','2025-05-16','2025-05-20','React','Client','Website'),(19,21,'Soumya','Artflora','soumya','Vinaya','','2025-05-14','2025-07-30','2025-08-20','wordpress','Client','Website'),(20,21,'Soumya','Ezyhires','soumya','Manju','Ganesh','2025-05-17','2025-07-30','2025-08-15','PHP, Codeignitor','Client','Web Application'),(21,21,'Soumya','Lakshmi Dental','Soumya','Soumya','Ganesh','2025-05-19','2025-06-20','2025-06-25','PHP','Client','Website'),(23,25,'Bhagath','South Sutra','Bhagath','Pavani','','2025-06-22','2025-06-15','2025-06-15','React JS,Node JS,Mysql','Client','Website'),(26,12,'Pavani','Gudnet','Amarendra','Pavani','','2025-06-11','2025-07-09','2025-07-09','React, Node Js','Client','Web Application'),(28,14,'Priya','Yasla - Mobile App','Prasanna','Priya','Soujanya','2025-06-11','2025-09-01','2025-09-04','React Native, Django','Client','Mobile Application'),(29,20,'Soujanya','Octane-HVAC','Bhargav','Priya/Darshan','Soujanya','2025-05-10','2025-07-05','2025-07-10','React','Client','Web Application'),(30,20,'Soujanya','Yasla','Prasanna','Priya','Soujanya','2025-06-04','2025-08-31','2025-09-04','React','Client','Website'),(32,21,'Soumya','Accounting Application','Amar','Soumya','Sumukh','2023-12-01','2025-07-15','2025-07-20','PHP,','Internal','Web Application'),(33,20,'Soujanya','VSMS','Bhargav','Soujanya','Soujanya','2025-06-09','2025-06-12','2025-06-14','React','Client','Website'),(42,19,'Amarender','Kranberries','Amar','Rajesh','Sumukh ','2025-07-04','2025-07-10','2025-07-12','PHP','Client','Website'),(43,11,'Hemanth','Funstay','Hemanth','Maniteja','Tharun','2025-01-10','2025-05-15','2025-05-15','React, Node js','Client','Web Application'),(44,6,'Prasanna','Poetry Designs Website ','Prasanna','Venu','','2025-05-29','2025-07-19','2025-07-19','React.js','Client','Website');
/*!40000 ALTER TABLE `project_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `response_text` text NOT NULL,
  `responded_by` varchar(100) NOT NULL,
  `response_date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` VALUES (10,12,'hello','admin','2025-06-27 11:41:02',NULL,38),(11,1,'Thanks for your feedback!','admin','2025-06-27 11:45:30',3,5),(12,13,'ok','admin','2025-06-28 05:19:59',NULL,39);
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_table`
--

DROP TABLE IF EXISTS `status_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `status_description` text NOT NULL,
  `status_percentage` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `is_latest` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `status_table_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project_table` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_table`
--

LOCK TABLES `status_table` WRITE;
/*!40000 ALTER TABLE `status_table` DISABLE KEYS */;
INSERT INTO `status_table` VALUES (7,12,'Completed','Completed',NULL,'2025-05-12 12:56:33','2025-06-17 05:17:18',0),(8,13,'In Progress','Pending Status:1)push notification,auto search for location and some ui chnages',80,'2025-05-12 13:37:06','2025-06-17 05:33:43',0),(10,15,'Completed','Completed',NULL,'2025-05-13 04:57:20','2025-06-17 05:40:12',0),(11,9,'In Progress','Working on react ui ',10,'2025-05-13 04:57:26','2025-06-17 05:37:05',0),(12,10,'In Progress','need to work on sales dashboard',60,'2025-05-13 05:01:20','2025-06-17 08:24:10',0),(13,17,'Completed','completed',NULL,'2025-05-13 06:14:07','2025-05-30 15:01:16',NULL),(14,16,'Completed','completed ',NULL,'2025-05-23 13:16:10','2025-06-17 05:27:34',0),(22,26,'In Progress','Static Screens and User registration completed ',20,'2025-06-17 05:16:43','0000-00-00 00:00:00',1),(23,12,'In Progress','All the modules completed, working on bulk sms API',70,'2025-06-17 05:17:18','0000-00-00 00:00:00',1),(25,23,'In Progress','Phone Pe and Ship Rocket Integration',75,'2025-06-17 05:27:23','0000-00-00 00:00:00',1),(26,16,'Completed','Handed over',NULL,'2025-06-17 05:27:34','0000-00-00 00:00:00',1),(27,28,'Completed','20',NULL,'2025-06-17 05:33:34','2025-06-17 05:47:00',0),(29,13,'In Progress','working one maps,subscription plan and refferal',20,'2025-06-17 05:33:43','2025-07-08 04:15:40',0),(31,30,'In Progress','website designed and waiting for phonepe approval',60,'2025-06-17 05:34:24','2025-07-04 04:16:11',0),(32,9,'In Progress','Working on Project Details and assigning team members',30,'2025-06-17 05:37:05','2025-07-08 04:07:36',0),(33,15,'In Progress','The application functionality is complete. We are now working on the WhatsApp API, which is 80% done',80,'2025-06-17 05:40:12','0000-00-00 00:00:00',1),(34,28,'In Progress','20',21,'2025-06-17 05:47:00','0000-00-00 00:00:00',1),(36,21,'In Progress','deloyement a',98,'2025-06-17 05:48:38','0000-00-00 00:00:00',1),(37,29,'In Progress',' Completed 60',60,'2025-06-17 05:49:10','0000-00-00 00:00:00',1),(38,19,'In Progress','new landing page is pending, product upload',50,'2025-06-17 05:52:44','0000-00-00 00:00:00',1),(39,32,'In Progress','pending work :taxation, batch wise inventory status updation',80,'2025-06-17 05:54:47','0000-00-00 00:00:00',1),(40,20,'In Progress',' it is in progress',20,'2025-06-17 06:07:58','0000-00-00 00:00:00',1),(41,33,'Completed','Static website is completed',NULL,'2025-06-17 07:04:12','0000-00-00 00:00:00',1),(42,10,'In Progress','phonepe interation pending',90,'2025-06-17 08:24:10','0000-00-00 00:00:00',1),(51,30,'Completed','website designed and waiting for phonepe approval',NULL,'2025-07-04 04:16:11','0000-00-00 00:00:00',1),(52,9,'In Progress','Working on Project Details and assigning team members',50,'2025-07-08 04:07:36','2025-07-08 04:27:35',0),(53,13,'In Progress','working one maps,subscription plan and refferal',90,'2025-07-08 04:15:40','0000-00-00 00:00:00',1),(54,43,'Completed','The Project is completed',NULL,'2025-07-08 04:18:57','0000-00-00 00:00:00',1),(55,44,'In Progress','90% work completed and waiting for the client review on colors .\nFonts need to be changed and team is working ',90,'2025-07-08 04:26:05','0000-00-00 00:00:00',1),(56,9,'In Progress','Admin panel completed and yet to start on the customer and user panel and client hasn\'t given any flow or updates',30,'2025-07-08 04:27:35','0000-00-00 00:00:00',1);
/*!40000 ALTER TABLE `status_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com','$2a$12$yUuo0iFBAvq4G34D67/NqOCbMDHDMVqQWxgACq2rU4TPmh6z/K1Va','admin','2025-05-08 06:20:12'),(2,'Teamlead','lead@gmail.com','$2a$12$L27LHYYlZZ1z24xMjMymNeIjaTs4pGevCM6083z/bEOVLpS4j3Lv6','teamlead','2025-05-08 06:20:29'),(3,'Manju','manjuprasad@iiiqai.com','$2a$12$r0StvcBjDL77CcqW6oWHKOsdmP3ULUeICtLJxMDBn9sHGLSetAWWG','teamlead','2025-05-08 06:22:40'),(4,'Bhargav','koduribhargav@iiiqai.com','$2a$12$f6fwKLLF7vhzqI4dy5sPSuHurta3NiGoS1c.hjOWMbpyBucdQ7jHq','teamlead','2025-05-08 13:36:42'),(6,'Prasanna','prasannakumarsg@iiiqai.com','$2a$12$9brU8LUSaUPD0Zgz2xaYYe8H4k.hG/.2UlAmwNK5ABg9YWjlXZNHa','teamlead','2025-05-09 03:55:55'),(7,'Harish','harishkodam@iiiqai.com','$2a$12$FM.d5j2vGX29QxL7LDvDiew2t7pYlHtqc8eFkN0YJmfI7DcdVEwd.','teamlead','2025-05-09 03:57:39'),(8,'Darshan','darshanurs@iiiqai.com','$2a$12$1iGoYzHtZTvEvKG05O33tON72f0e9wuZ6HE.5fgT5P95LGI0U/gli','teamlead','2025-05-09 03:58:48'),(9,'Vamshi','vamshikrishna1564@iiiqai.com','$2a$12$J5VdXHZkdAChd3iLZByUQuqCEEWuOO1nrerkiZUSFtO8rlrWw1qbm','teamlead','2025-05-09 04:00:07'),(10,'Sai Krishna','saikrishna.ausala@iiiqai.com','$2a$12$y3xfhay0l/E6qs.foz5zKOojE67iwm1OjCJvVjJotFv28JOf0sOaW','teamlead','2025-05-09 04:01:49'),(11,'Hemanth','hemanthuppala@iiiqai.com','$2a$12$/Ir5bB3OY6W60tOfvLJsxuVVEmZxjyOTQBZ6N00s/9fNJypnGibYK','teamlead','2025-05-09 04:02:44'),(12,'Pavani','pavanimyana@iiiqai.com','$2a$12$3Nzhko4y4rZCo7z45XN44etrFoOQw612IhSjssZxWIKHKCmRUhh6G','teamlead','2025-05-09 04:03:48'),(13,'Sai Krushna','saikrushna.kadarla@iiiqai.com','$2a$12$8z0us1rfYgA7AmgZEA6V2O30n6iZUjb2q69NFGKPllXOBWtp1Hiui','teamlead','2025-05-09 04:04:48'),(14,'Priya','priyakodam@iiiqai.com','$2a$12$yIogcb2DOFcsjxDq2T4/QOhvVoSsfVZMtt/.Y5U5GhLRb7UI.Km0a','teamlead','2025-05-09 04:05:43'),(15,'Rahul','rahuldusa@iiiqai.com','$2a$12$L.s5jJ7kp5NSlNx89S69ueoZEOQWyYlNO9hZQUix2HsH3ncWAXmMO','teamlead','2025-05-09 04:07:52'),(16,'Bharath','bharathkumar.kusuma@iiiqai.com','$2a$12$2iNGkyeg6CHiUpkIsfoRIuJchN0AzGS9ASrEHl5NEeKsCqh9f9ofO','teamlead','2025-05-09 04:09:42'),(17,'Vinay','vinaykumar@iiiqai.com','$2a$12$rx.EVoQludUArkmpOgIxSOm7bVTDgYlvfQnJVey3CqKkzhX9sq8ay','teamlead','2025-05-09 04:10:42'),(18,'Srithajana','srithaalwar4@gmail.com','$2a$12$jc6LiM2x.THEnRfdbALIV.mP/ln6GaUt5ivUee7QpLP/C66T6Bt.q','teamlead','2025-05-09 04:11:46'),(19,'Amarender','amarendravangala@gmail.com','$2a$12$BEEuwH9zApmU.fhAFM3XN.t3FvIADgiONVwpk1vU6sMinQf1iWvcC','teamlead','2025-05-09 04:13:10'),(20,'Soujanya','soujanya@iiiqai.com','$2a$12$eAj7plxikHyI6LATTfAWk.jXNoZ5Lskm9BD0zJ7tRNk9xAeyGKi32','teamlead','2025-05-09 04:25:31'),(21,'Soumya','rssoumya@iiiqai.com','$2a$12$aAF649Yn2riErmffp1uQF.VbYc3ufbQZIa/ES75Xim/ec5GKuOwg6','teamlead','2025-05-09 04:15:04'),(22,'Subhash','subhashnetha.mangalaram@gmail.com','$2a$12$VOjTmd62rU.lrEPwebMoIeOL7kDJOczqgS.8ZH.jt0jkH7NI5v9XK','teamlead','2025-05-09 04:17:02'),(23,'Alekhya','alekhyakodam@iiiqai.com','$2a$12$B8W/NqzK.hzh023hBdP3VOIZKfM27aKk0CgG4RHbjx/.5I5enEwJy','teamlead','2025-05-09 04:25:11'),(25,'Bhagath','bhagath.koduri@iiiqai.com','$2a$12$EheXyWtBW2Bm3/OZDfNMqOOSwf0NZn19bwP/g7cPSSn/Tjo6FwouK','teamlead','2025-06-03 05:57:02'),(26,'Test','Test@gmail.com','$2y$10$HK.D76JkglWmsPosYDgriejc.Dzz/lFkHI4fwIWO1BFkF/cLjNSUK','teamlead','2025-06-18 08:05:08'),(28,'Rahul kumar','dusarahul21@gmail.com','$2y$10$Y6XK39.III.TA2rMlwWdUu3uWXqGKqAhd0MvtpdYmImftnZTtXB16','teamlead','2025-07-11 02:39:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-12  6:38:36
