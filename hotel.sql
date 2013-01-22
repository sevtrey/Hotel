-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Янв 22 2013 г., 07:32
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `hotel_admin`
--

INSERT INTO `hotel_admin` (`admin_code`, `admin_name`, `admin_login`, `admin_pass`, `admin_email`, `admin_active`, `admin_rstatic`, `admin_ralbum`, `admin_radmin`) VALUES
(1, 'Юрий', 'gooman', 'b633e58ff7d328a069f54451d1685e0a', 'puklo24@gmail.com', 1, 1, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `hotel_static`
--

INSERT INTO `hotel_static` (`static_code`, `static_title`, `static_abstract`, `static_text`, `static_seo_title`, `static_seo_desc`, `static_seo_key`, `static_type`) VALUES
(1, 'Главная', 'Верхнее описание главной страницы', 'Нижнее описание главной страницы', 'Главная', 'это главная страница', 'отель, севастополь, hotel, стрелецкая, бухта', 'page'),
(2, 'Галерея1', '', '', 'Галерея1', 'номера', 'номер, квартира, апартаменты', 'gallery');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
