-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 06 2016 г., 16:50
-- Версия сервера: 5.7.9
-- Версия PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `2step`
--

-- --------------------------------------------------------

--
-- Структура таблицы `codes`
--

DROP TABLE IF EXISTS `codes`;
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first` int(11) DEFAULT NULL,
  `second` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `devicename` text NOT NULL,
  `secret` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `devices`
--

INSERT INTO `devices` (`id`, `uid`, `devicename`, `secret`) VALUES
(10, 1, 'WIN10-PC', '7f8e0eb8de4e20c5ddb64b884bf3b9b3'),
(12, 2, 'WIN10-PC', '3e15c1c6936279b4115c585338fa924f'),
(13, 5, 'WIN10-PC', '3e15c1c6936279b4115c585338fa924f');

-- --------------------------------------------------------

--
-- Структура таблицы `tokens`
--

DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tokens`
--

INSERT INTO `tokens` (`id`, `uid`, `token`, `expired`) VALUES
(1, 1, '3021e68df9a7200135725c6331369a22', 0),
(15, 2, '645f86b5cec4da0a56ffea7a891720c9', 1),
(16, 5, '58473c0cf0d3a91a67640caff09c74f3', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(32) NOT NULL,
  `deviceid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `deviceid`) VALUES
(1, 'admin', 'mrB4el@outlook.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'mrB4el', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(3, 'Guest', 'admin@admin.com', 'd41d8cd98f00b204e9800998ecf8427e', NULL),
(4, 'test', 'admin@admin.com', '098f6bcd4621d373cade4e832627b4f6', NULL),
(5, 'someusername', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
