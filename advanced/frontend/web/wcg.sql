-- MySQL dump 10.13  Distrib 5.6.19, for debian6.0 (x86_64)
--
-- Host: localhost    Database: wcg
-- ------------------------------------------------------
-- Server version	5.6.19

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
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) DEFAULT '0',
  `key_code` char(64) NOT NULL DEFAULT '',
  `command` char(128) NOT NULL DEFAULT '',
  `identity` char(128) NOT NULL DEFAULT '',
  `identity_value` char(255) NOT NULL DEFAULT '',
  `status_code` char(32) NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_log`
--

LOCK TABLES `api_log` WRITE;
/*!40000 ALTER TABLE `api_log` DISABLE KEYS */;
INSERT INTO `api_log` VALUES (1,1,-1,'','UserRegister','','','521','用户在该商户下已存在','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"\",\"TrxId\":\"\",\"UsrId\":\"lixiao\",\"RespCode\":\"521\",\"RespDesc\":\"\\u7528\\u6237\\u5728\\u8be5\\u5546\\u6237\\u4e0b\\u5df2\\u5b58\\u5728\",\"IdNo\":\"\",\"ChkValue\":\"35158E8B43350E2558CCC50C734598BC4BEABBE77E35E16CD873ABA5F22E9E506A9702D7C369CE71227D2FFF3DD3B660910C7156CD22AB425DE2156A169031FD930FD37D7651E4D82ADA9164E07F4C63E73A71E041C61CD363DE89AF41A2F65FF052534D899557C4B963FF4B9816F70E9EDB19891947C75E3452DEE6884E4677\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"\",\"CmdId\":\"UserRegister\"}',1406635477,1406635477),(2,1,-1,'','UserRegister','','','100','请求参数非法','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"1\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"\",\"UsrId\":\"lixiao111\",\"RespCode\":\"100\",\"RespDesc\":\"\\u8bf7\\u6c42\\u53c2\\u6570\\u975e\\u6cd5\",\"IdNo\":\"111222111222111\",\"ChkValue\":\"7380A5C905D6B1DF1BF5D6A890D2B4A0EA4889F7E2873B421CE498B153250AB9993EB520842F0D79645E4D83BF411C3B124DC3F70D4385C9DCAD5E421D32BDD280997298A613C374075D575791E0F489AF97BD8D9F28BC6ADA844E496F63B6EE24DF440822325924E3BF8881523F8129F021682B604A4D8F3D6005113D1AB699\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406635599,1406635599),(3,1,-1,'','UserRegister','','','506','身份证和姓名校验失败','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"\",\"UsrId\":\"lixiao111\",\"RespCode\":\"506\",\"RespDesc\":\"\\u8eab\\u4efd\\u8bc1\\u548c\\u59d3\\u540d\\u6821\\u9a8c\\u5931\\u8d25\",\"IdNo\":\"111222111222111\",\"ChkValue\":\"0626BB11E90B51FBFE3220919DA148FF6B16CC7AADEAAA092C37818A1B07A7C4EF93C9CF9881D0C127F0F88FF89B53409BEB59008F81BE9FFA8C0ABA2FD45E56EDB01D607FCEB076800A86AB49B8EBB7CE0BFDBA52062E864B06B9EF5E363CDFC8A761980757D21BB7586935DC0F7B05F3318794E2B5FE8B532360F98BFA1A2F\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406635662,1406635662),(4,1,-1,'','UserRegister','','','521','用户在该商户下已存在','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"\",\"UsrId\":\"lixiao111\",\"RespCode\":\"521\",\"RespDesc\":\"\\u7528\\u6237\\u5728\\u8be5\\u5546\\u6237\\u4e0b\\u5df2\\u5b58\\u5728\",\"IdNo\":\"15232419741201581x\",\"ChkValue\":\"843EFECC8009A6AF5A74A72E30F0C116952CF5AD8257F8494D0AD0A6C6A852603009231C08EC8D6D57B6D63DF0B7515AFC072C376C8A9D6693668A86CAB5E91E6E8FB29C84977A2DEAEFCD0FAD93771E1AC7454D412845D4BD19DBFC5C916ADAD91C3222B769497C3F66C1CCCF85AF4B1B2EC54A373287DF6A499C213E18FA76\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406635803,1406635803),(5,1,-1,'','UserRegister','','','521','用户在该商户下已存在','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"\",\"UsrId\":\"lixiao111\",\"RespCode\":\"521\",\"RespDesc\":\"\\u7528\\u6237\\u5728\\u8be5\\u5546\\u6237\\u4e0b\\u5df2\\u5b58\\u5728\",\"IdNo\":\"15232419741201581x\",\"ChkValue\":\"843EFECC8009A6AF5A74A72E30F0C116952CF5AD8257F8494D0AD0A6C6A852603009231C08EC8D6D57B6D63DF0B7515AFC072C376C8A9D6693668A86CAB5E91E6E8FB29C84977A2DEAEFCD0FAD93771E1AC7454D412845D4BD19DBFC5C916ADAD91C3222B769497C3F66C1CCCF85AF4B1B2EC54A373287DF6A499C213E18FA76\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406635913,1406635913),(6,1,-1,'','UserRegister','','','521','用户在该商户下已存在','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"\",\"UsrId\":\"lixiao111\",\"RespCode\":\"521\",\"RespDesc\":\"\\u7528\\u6237\\u5728\\u8be5\\u5546\\u6237\\u4e0b\\u5df2\\u5b58\\u5728\",\"IdNo\":\"220181197705061927\",\"ChkValue\":\"843EFECC8009A6AF5A74A72E30F0C116952CF5AD8257F8494D0AD0A6C6A852603009231C08EC8D6D57B6D63DF0B7515AFC072C376C8A9D6693668A86CAB5E91E6E8FB29C84977A2DEAEFCD0FAD93771E1AC7454D412845D4BD19DBFC5C916ADAD91C3222B769497C3F66C1CCCF85AF4B1B2EC54A373287DF6A499C213E18FA76\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406636270,1406636270),(7,1,0,'','UserRegister','','','000','成功','{\"UsrCustId\":\"6000060003273121\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"UsrName\":\"%E9%99%88%E6%B4%8B\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"18900022100\",\"TrxId\":\"189678791061774364\",\"UsrId\":\"ydf_888888\",\"RespCode\":\"000\",\"RespDesc\":\"\\u6210\\u529f\",\"IdNo\":\"220181197705061927\",\"ChkValue\":\"8001DF4C3AF60CFF9548B2A3558E30B18E84F1A36B82CD623A18F34186AEB60DEAF5331C36EE4F7AD79F32D7159AAF7131E0499FFDC1DE4CBB6E482014883AEF5FD7A751E2BBAF151EA317F7F2FE0DC4DFF2E20D9FE2D570FA586587ACF1905F3DDDE356891362F2D8B3DF5B39E23104F26D0C325F8C71983988FB345EB16C51\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406636441,1406636441),(8,1,-1,'','UserRegister','','','509','证件号在该商户下已存在','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"00\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"\",\"TrxId\":\"\",\"UsrId\":\"777777\",\"RespCode\":\"509\",\"RespDesc\":\"\\u8bc1\\u4ef6\\u53f7\\u5728\\u8be5\\u5546\\u6237\\u4e0b\\u5df2\\u5b58\\u5728\",\"IdNo\":\"220181197705061927\",\"ChkValue\":\"2711E3C3E8D47BCAD10C9D2D1EA6AC502FED8779D1529C3841368E7144017CDD2ACB370DEBA0583055E9FB042D972DA6822E7EF36BE65C69B85C4CD3558F17FD797082C9769BF6A2BB2165913A026CE731A0EFA6E4A0491164FA3B10564BE2861C8485746E095C9D6DBB73CDE05AFF78C524009B665FC71813E4C9615D584FB4\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"email@email.com\",\"CmdId\":\"UserRegister\"}',1406636994,1406636994),(9,1,-1,'','UserRegister','','','100','请求参数非法','{\"UsrCustId\":\"\",\"BgRetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\\/backend\",\"IdType\":\"\",\"MerPriv\":null,\"RetUrl\":\"http:\\/\\/m.wangcaigu.com\\/cnpnr\",\"UsrMp\":\"13899002166\",\"TrxId\":\"\",\"UsrId\":\"xiaomaomi\",\"RespCode\":\"100\",\"RespDesc\":\"\\u8bf7\\u6c42\\u53c2\\u6570\\u975e\\u6cd5\",\"IdNo\":\"\",\"ChkValue\":\"17B64E6DEE29A80AEAD1418B90428736EE19672B30A32719B0FE6F165BFDF967DD12C4B0BE96459293F795B486B38559A33A425EA12AB9EFD1876CC12EE842C4301FB91C56DAB82D4A96DDFFB55FC37276B5FFEC1D6690D08C006B97129FA41DBAA1679D215857878C8CD8B7A0C4C5E336622F08DCFB9B7CD3A9147DB4FF955D\",\"MerCustId\":\"6000060001283917\",\"UsrEmail\":\"13899002166\",\"CmdId\":\"UserRegister\"}',1406649240,1406649240);
/*!40000 ALTER TABLE `api_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(32) NOT NULL,
  `email` char(32) NOT NULL,
  `mobile` char(16) NOT NULL,
  `password_hash` char(64) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `role` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'abiao','276464467@qq.com','13488790156','$2y$13$6qoFfDOrFOorzGbhEHKoQ.i9tajdrKTjCNwlN3MxdHbyus.eIvMwe','pkm6LUD8i-wcMEKotZObd0UY919oWQpd',10,10,1406703482,1406703482);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wcg_user`
--

DROP TABLE IF EXISTS `wcg_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wcg_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `wcg_uid` int(10) unsigned NOT NULL,
  `cnpnr_account` char(16) NOT NULL DEFAULT '',
  `balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `avl_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `freeze_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `slb_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `invest_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `interest_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `returned_interest_balance` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `updated_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wcg_user`
--

LOCK TABLES `wcg_user` WRITE;
/*!40000 ALTER TABLE `wcg_user` DISABLE KEYS */;
INSERT INTO `wcg_user` VALUES (1,1,17,'',0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,0.0000,1406703482,1406703482);
/*!40000 ALTER TABLE `wcg_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wechat_user`
--

DROP TABLE IF EXISTS `wechat_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wechat_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `open_id` char(128) NOT NULL,
  `nickname` char(64) DEFAULT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wechat_user`
--

LOCK TABLES `wechat_user` WRITE;
/*!40000 ALTER TABLE `wechat_user` DISABLE KEYS */;
INSERT INTO `wechat_user` VALUES (1,1,'111111',NULL,1406703482,1406703482);
/*!40000 ALTER TABLE `wechat_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-30 15:59:33
