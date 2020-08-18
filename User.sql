-- phpMyAdmin SQL Dump
-- version 2.11.9.3
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: Aug 13, 2020, 02:39 PM
-- 伺服器版本: 4.1.24
-- PHP 版本: 4.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `User`
--

-- --------------------------------------------------------

--
-- 資料表格式： `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL auto_increment,
  `Username` varchar(20) NOT NULL default '',
  `Password` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 列出以下資料庫的數據： `User`
--

INSERT INTO `User` (`id`, `Username`, `Password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'test', '202cb962ac59075b964b07152d234b70'),
(3, 'abc', 'caf1a3dfb505ffed0d024130f58c5cfa'),
(4, 'test2', '202cb962ac59075b964b07152d234b70');
