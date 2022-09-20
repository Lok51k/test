-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Сен 13 2022 г., 21:07
-- Версия сервера: 10.4.22-MariaDB
-- Версия PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `security_service`
--

-- --------------------------------------------------------

--
-- Структура таблицы `guards`
--

CREATE TABLE `guards` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_guard_post` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `biography` varchar(255) NOT NULL,
  `img_path` varchar(75) NOT NULL,
  `year_of_birth` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `guards`
--

-- --------------------------------------------------------

--
-- Структура таблицы `guard_posts`
--

CREATE TABLE `guard_posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `guard_posts`
--


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `guards`
--
ALTER TABLE `guards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guars_post_index` (`id_guard_post`);

--
-- Индексы таблицы `guard_posts`
--
ALTER TABLE `guard_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `guards`
--
ALTER TABLE `guards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `guard_posts`
--
ALTER TABLE `guard_posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `guards`
--
ALTER TABLE `guards`
  ADD CONSTRAINT `guards_ibfk_1` FOREIGN KEY (`id_guard_post`) REFERENCES `guard_posts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
