-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: laravel-shop
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu18.04.1

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
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'首页','fa-bar-chart','/',NULL,NULL,'2019-08-07 01:46:13'),(2,0,2,'系统管理','fa-tasks',NULL,NULL,NULL,'2019-08-07 01:46:53'),(3,2,3,'管理员','fa-users','auth/users',NULL,NULL,'2019-08-07 01:47:13'),(4,2,4,'角色','fa-user','auth/roles',NULL,NULL,'2019-08-07 01:47:27'),(5,2,5,'权限','fa-ban','auth/permissions',NULL,NULL,'2019-08-07 01:47:48'),(6,2,6,'菜单','fa-bars','auth/menu',NULL,NULL,'2019-08-07 01:48:03'),(7,2,7,'操作日志','fa-history','auth/logs',NULL,NULL,'2019-08-07 01:48:19'),(8,0,8,'用户管理','fa-user','/users',NULL,'2019-08-07 06:53:17','2019-08-17 18:30:30'),(9,0,9,'商品管理','fa-cubes',NULL,NULL,'2019-08-08 01:38:19','2020-02-17 17:51:53'),(10,0,12,'订单管理','fa-rmb','/orders',NULL,'2019-08-17 18:30:09','2020-02-17 17:54:52'),(11,0,13,'优惠券管理','fa-tags','/coupon_codes',NULL,'2019-08-21 14:39:04','2020-02-17 17:54:52'),(12,0,14,'类目管理','fa-bars','/categories',NULL,'2020-02-16 16:57:46','2020-02-17 17:54:52'),(13,9,10,'众筹商品','fa-flag-checkered','/crowdfunding_products',NULL,'2020-02-17 17:54:00','2020-02-17 17:54:52'),(14,9,11,'普通商品','fa-cubes','/products',NULL,'2020-02-17 17:54:43','2020-02-17 17:54:52');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'All permission','*','','*',NULL,NULL),(2,'Dashboard','dashboard','GET','/',NULL,NULL),(3,'Login','auth.login','','/auth/login\r\n/auth/logout',NULL,NULL),(4,'User setting','auth.setting','GET,PUT','/auth/setting',NULL,NULL),(5,'Auth management','auth.management','','/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs',NULL,NULL),(6,'用户管理','users','','/users*','2019-08-07 06:26:41','2019-08-07 06:55:00'),(7,'商品管理','products','','/products*','2019-08-26 09:02:52','2019-08-26 09:02:52'),(8,'优惠券管理','coupon_codes','','/coupon_codes*','2019-08-26 09:03:33','2019-08-26 09:03:33'),(9,'订单管理','orders','','/orders*','2019-08-26 09:04:02','2019-08-26 09:04:02');
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL),(2,3,NULL,NULL),(2,4,NULL,NULL),(2,6,NULL,NULL),(2,7,NULL,NULL),(2,8,NULL,NULL),(2,9,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,NULL,NULL),(2,2,NULL,NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2019-08-07 01:05:12','2019-08-07 01:05:12'),(2,'运营','operation','2019-08-07 06:28:00','2019-08-07 06:28:00');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_user_permissions`
--

LOCK TABLES `admin_user_permissions` WRITE;
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$D8H24shr3/8MDlhAgDIqbOxaUQDZEHgXlN0CK1NiuG3sqykovv8gq','Administrator',NULL,'XsrQmhC7dBM2ZwYn9VoAlX5Pk5b6bXaP6PDZ3U24vY6aCPiUPsttcovSD1wt','2019-08-07 01:05:12','2019-08-07 01:05:12'),(2,'operator','$2y$10$7eiW2j7j.BOFMhwRmhQTUevhn.eclCvbhf/Q3TXNY90iaQ3bz.dsa','运营',NULL,'vWZdEyihDaPyixOSdNV1y2KEa6at0BeH8OYD1rHvmK5xulmmqRvpUmzW2N1K','2019-08-07 06:29:27','2019-08-07 06:29:27');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-17 10:08:54
