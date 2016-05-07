-- MySQL dump 10.14  Distrib 5.5.47-MariaDB, for Linux ()
--
-- Host: localhost    Database: france
-- ------------------------------------------------------
-- Server version	5.5.47-MariaDB

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `affinities`
--

DROP TABLE IF EXISTS `affinities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affinities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` smallint(6) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bets` (
  `bet_id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL DEFAULT '0',
  `match_id` tinyint(4) NOT NULL DEFAULT '0',
  `bgt1` tinyint(4) NOT NULL DEFAULT '0',
  `bgt2` tinyint(4) NOT NULL DEFAULT '0',
  `pick` tinyint(4) NOT NULL DEFAULT '0',
  `weight` tinyint(4) NOT NULL DEFAULT '0',
  `processed` tinyint(4) NOT NULL,
  PRIMARY KEY (`bet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18717 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `counter_vis`
--

DROP TABLE IF EXISTS `counter_vis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counter_vis` (
  `id` tinyint(9) NOT NULL AUTO_INCREMENT,
  `count_vis` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `country_code` char(2) COLLATE utf8_bin DEFAULT NULL,
  `country_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  KEY `idx_country_code` (`country_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `user_nick` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `last_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2510 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forum1`
--

DROP TABLE IF EXISTS `forum1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread` int(11) NOT NULL DEFAULT '0',
  `player_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(70) NOT NULL DEFAULT '',
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `content` text NOT NULL,
  `last_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `player_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forum2010`
--

DROP TABLE IF EXISTS `forum2010`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum2010` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `user_nick` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `last_mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mo` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1164 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `letter` char(1) NOT NULL DEFAULT '',
  `over` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` smallint(6) NOT NULL,
  `match_id` smallint(6) NOT NULL,
  `current_points` float NOT NULL,
  `correct_bets` smallint(6) NOT NULL,
  `points` float NOT NULL,
  `bet` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10115 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language` (
  `id` mediumint(4) NOT NULL AUTO_INCREMENT,
  `word_hu` varchar(120) CHARACTER SET utf8 NOT NULL,
  `word_fr` varchar(120) CHARACTER SET utf8 NOT NULL,
  `word_en` varchar(120) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL DEFAULT '00:00:00',
  `place` tinyint(4) NOT NULL DEFAULT '0',
  `descr` varchar(30) NOT NULL DEFAULT '',
  `t1` mediumint(9) NOT NULL DEFAULT '0',
  `t2` mediumint(9) NOT NULL DEFAULT '0',
  `g1` tinyint(4) NOT NULL DEFAULT '0',
  `g2` tinyint(4) NOT NULL DEFAULT '0',
  `res` tinyint(4) NOT NULL DEFAULT '0',
  `played` tinyint(4) NOT NULL DEFAULT '0',
  `odds1` varchar(8) NOT NULL DEFAULT '0',
  `odds2` varchar(8) NOT NULL DEFAULT '0',
  `oddsD` varchar(8) NOT NULL DEFAULT '0',
  `total_picks` int(11) NOT NULL,
  `no_tie` tinyint(4) NOT NULL DEFAULT '0',
  `round_id` tinyint(4) NOT NULL DEFAULT '0',
  `origin` varchar(20) NOT NULL DEFAULT '',
  `short_desc` varchar(6) NOT NULL,
  `processed` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_title` varchar(80) NOT NULL DEFAULT '',
  `comments` varchar(255) NOT NULL DEFAULT '',
  `sub` varchar(10) NOT NULL DEFAULT '0',
  `media_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `movie_title` (`movie_title`,`comments`)
) ENGINE=MyISAM AUTO_INCREMENT=234 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `places`
--

DROP TABLE IF EXISTS `places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `places` (
  `place_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `city` varchar(20) NOT NULL DEFAULT '',
  `stadium` varchar(40) NOT NULL DEFAULT '',
  `capacity` int(11) NOT NULL DEFAULT '0',
  `acronym` varchar(10) NOT NULL,
  `trans` smallint(6) NOT NULL,
  PRIMARY KEY (`place_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `players` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `team_id` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `top` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4120 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rounds`
--

DROP TABLE IF EXISTS `rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rounds` (
  `round_id` tinyint(4) NOT NULL DEFAULT '0',
  `descr` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rss_history`
--

DROP TABLE IF EXISTS `rss_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rss_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `pubDate` varchar(40) NOT NULL,
  `description` varchar(70) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=972 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rss_queries`
--

DROP TABLE IF EXISTS `rss_queries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rss_queries` (
  `id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idx` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scorer`
--

DROP TABLE IF EXISTS `scorer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scorer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `top_scorer` varchar(30) NOT NULL DEFAULT '',
  `top` tinyint(4) NOT NULL DEFAULT '0',
  `code` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=385 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `team_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `group_name` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `code` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `winner` tinyint(4) NOT NULL DEFAULT '0',
  `current_pos` tinyint(4) NOT NULL DEFAULT '0',
  `m_played` smallint(6) NOT NULL DEFAULT '0',
  `W` tinyint(4) NOT NULL DEFAULT '0',
  `D` tinyint(4) NOT NULL DEFAULT '0',
  `L` tinyint(4) NOT NULL DEFAULT '0',
  `gf` smallint(6) NOT NULL DEFAULT '0',
  `ga` smallint(6) NOT NULL DEFAULT '0',
  `pts` smallint(6) NOT NULL DEFAULT '0',
  `players_list` tinyint(4) NOT NULL DEFAULT '0',
  `trans` smallint(6) NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `timezone`
--

DROP TABLE IF EXISTS `timezone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timezone` (
  `zone_id` int(10) NOT NULL,
  `abbreviation` varchar(6) COLLATE utf8_bin NOT NULL,
  `time_start` int(11) NOT NULL,
  `gmt_offset` int(11) NOT NULL,
  `dst` char(1) COLLATE utf8_bin NOT NULL,
  KEY `idx_zone_id` (`zone_id`),
  KEY `idx_time_start` (`time_start`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usergroups`
--

DROP TABLE IF EXISTS `usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usergroups` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` smallint(6) NOT NULL,
  `member` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=621 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` mediumint(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `password` varchar(41) CHARACTER SET latin1 NOT NULL,
  `first_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `age` tinyint(4) NOT NULL DEFAULT '0',
  `city` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `country` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `fav_team` varchar(30) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `fav_player` varchar(60) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `comments` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `last_login` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bets_phase1` tinyint(4) NOT NULL DEFAULT '0',
  `bets_phase2` tinyint(4) NOT NULL DEFAULT '0',
  `profile_edited` tinyint(4) NOT NULL DEFAULT '0',
  `top_scorer` int(30) NOT NULL DEFAULT '0',
  `sweet` tinyint(4) NOT NULL DEFAULT '0',
  `zincou` tinyint(4) NOT NULL DEFAULT '0',
  `player` tinyint(4) NOT NULL DEFAULT '0',
  `winner` int(11) NOT NULL DEFAULT '0',
  `current_points` float NOT NULL DEFAULT '0',
  `current_correct` tinyint(4) NOT NULL DEFAULT '0',
  `current_incorrect` tinyint(4) NOT NULL DEFAULT '0',
  `bet_money` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(60) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `current_ranking` smallint(6) NOT NULL DEFAULT '0',
  `language` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `friend` tinyint(4) NOT NULL DEFAULT '0',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `last_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contact` smallint(6) NOT NULL,
  `timezone` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `zone`
--

DROP TABLE IF EXISTS `zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zone` (
  `zone_id` int(10) NOT NULL AUTO_INCREMENT,
  `country_code` char(2) COLLATE utf8_bin NOT NULL,
  `zone_name` varchar(35) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`zone_id`),
  KEY `idx_zone_name` (`zone_name`)
) ENGINE=MyISAM AUTO_INCREMENT=417 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-06 23:20:36
