-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 22 2013 г., 10:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `hotel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `hotel_admin`
--

CREATE TABLE IF NOT EXISTS `hotel_admin` (
  `admin_code` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `admin_name` varchar(200) NOT NULL DEFAULT '',
  `admin_login` varchar(200) NOT NULL DEFAULT '',
  `admin_pass` varchar(200) NOT NULL DEFAULT '',
  `admin_email` varchar(200) NOT NULL DEFAULT '',
  `admin_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Админ активен?',
  `admin_rstatic` tinyint(4) DEFAULT '0' COMMENT 'Права админа на управление статическими страницами',
  `admin_ralbum` tinyint(4) DEFAULT '0' COMMENT 'Права админа на управление альбомом',
  `admin_radmin` tinyint(4) DEFAULT '0' COMMENT 'Права админа на редактирование списка админов',
  PRIMARY KEY (`admin_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `hotel_admin`
--

INSERT INTO `hotel_admin` (`admin_code`, `admin_name`, `admin_login`, `admin_pass`, `admin_email`, `admin_active`, `admin_rstatic`, `admin_ralbum`, `admin_radmin`) VALUES
(1, 'Юрий', 'gooman', 'b633e58ff7d328a069f54451d1685e0a', 'puklo24@gmail.com', 1, 1, 1, 1),
(2, 'Алексей', 'sevtrey', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'sevtrey@gmail.com', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `hotel_picture`
--

CREATE TABLE IF NOT EXISTS `hotel_picture` (
  `picture_code` int(11) NOT NULL AUTO_INCREMENT,
  `static_code` int(11) NOT NULL,
  `picsmall` varchar(200) DEFAULT NULL,
  `picbig` varchar(200) DEFAULT NULL,
  `picpos` int(11) NOT NULL,
  `piccomment` text,
  PRIMARY KEY (`picture_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `hotel_picture`
--

INSERT INTO `hotel_picture` (`picture_code`, `static_code`, `picsmall`, `picbig`, `picpos`, `piccomment`) VALUES
(1, 2, 'cherno_small.jpg', 'cherno_big.jpg', 1, 'Чернобыль');

-- --------------------------------------------------------

--
-- Структура таблицы `hotel_static`
--

CREATE TABLE IF NOT EXISTS `hotel_static` (
  `static_code` int(11) NOT NULL AUTO_INCREMENT,
  `static_title` varchar(200) NOT NULL DEFAULT '',
  `static_abstract` text NOT NULL COMMENT 'Краткий текст страницы',
  `static_text` text NOT NULL COMMENT 'Полный текст страницы',
  `static_seo_title` text,
  `static_seo_desc` text,
  `static_seo_key` text,
  `static_type` varchar(11) NOT NULL DEFAULT 'page' COMMENT 'Определает тип страница (обычная страница или галерея)',
  PRIMARY KEY (`static_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `hotel_static`
--

INSERT INTO `hotel_static` (`static_code`, `static_title`, `static_abstract`, `static_text`, `static_seo_title`, `static_seo_desc`, `static_seo_key`, `static_type`) VALUES
(1, 'Главная', '<p>\n<strong><font color="#33cccc">ДОСТУПНЫЙ ОТДЫХ В СЕВАСТОПОЛЕ</font></strong>\n</p>\n<p>\n&nbsp;Вас приветствует частный гостевой дом &quot;Бухта Стрелецкая&quot;!\n</p>\n<p>\nКрымское солнце и ласковое Черное море подарят вам незабываемые дни, а наш пансионат всегда готов прелложить Вам приятный отдых по доступной цене! Частный гостевой дом &quot;Бухта Стрелецкая&quot; находится в укромном, далеком от суеты, машин и толп людей в частном секторе, и в то же время 10-15 мин. езды отделяют его от центра города. Гостевой дом находится в непосредственной близости от заповедника &quot;Херносес Таврический&quot; и двух пляжей.\n</p>\n<p>\nЖелаем Вам приятного отдыха в Крыму!&nbsp;\n</p>\n', '<p>\r\n<strong><font color="#33cccc">ГОСТЕВОЙ ДОМ &quot;БУХТА СТРЕЛЕЦКАЯ&quot;</font></strong>\r\n</p>\r\n<p>\r\nНовое двухэтажное здание гостиницы включает 16 номеров - 8 трехместных, 8 &nbsp;четырехместных. Общее количество мест в гостинице - 56.\r\n</p>\r\n<p>\r\nТакже отдыхающим предлагается утопающий в зелени каменный 2-х комнатный домик со всеми удосбвтвами (бойлер, ТВ, холодильник, туалет).\r\n</p>\r\n<p>\r\nУсловия проживания: душевые, туалеты, умывальники находятся в отдельном санитарном блоке. Горячая и холодная вода постоянно. Питаются отдыхающие в собственной столовой. Есть возможность для приготовления пищи самостоятельно.\r\n</p>\r\n<p>\r\nНа территории хостела: мангал, газон, беседка, клумбы, ТВ, много фруктовых деревьев.\r\n</p>\r\n<p>\r\nГородской пляж: мелкая галька, песок. На пляже - прокат квадроциклов, шезлонгов, бананов.&nbsp;\r\n</p>\r\n', 'Главная', 'это главная страница', 'отель, севастополь, hotel, стрелецкая, бухта', 'page'),
(2, 'Галерея1', '', '', 'Галерея1', 'номера', 'номер, квартира, апартаменты', 'gallery');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
