-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Сен 03 2024 г., 13:41
-- Версия сервера: 8.0.39-0ubuntu0.24.04.2
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$QbOa5LthH22BEGWTJ/xr1eRzp7qdu8UMihtWljoB7.qxZssR8kym2', '2024-09-03 09:37:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `gender`, `birth_date`, `created_at`) VALUES
(13, 'john', '$2y$10$4blFRrzgB9WZgYg.ZC19ge7ml/JkkMtyDT57BPHSt/Qw85sewd9oa', 'John', 'Doe', 'male', '2024-11-11', '2024-09-03 12:24:32'),
(14, 'dima', '$2y$10$Py000u7RnYL4I0xGufQPVOQ45JXlTmaUjUN8AbsxoS6b2Lp9Ok5fy', 'Dima', 'Tishenko', 'male', '2002-11-11', '2024-09-03 12:28:49'),
(15, 'sergey', '$2y$10$cvAJE8wOlyte2kTr7ZxWf.9lXr9VzSSx8KH.2P.Wz9dj4vful8l9y', 'Pushkin', 'Alexander', 'male', '1799-11-11', '2024-09-03 12:29:36'),
(16, 'tyler', '$2y$10$zIGNIsKEOrHuZS03/z8IJe03/cfgiDy1gRcU3eT2K3WpB45ZKKwk6', 'Tyler', 'Durden', 'male', '1799-11-11', '2024-09-03 12:30:01'),
(17, 'fs', '$2y$10$iCIvS.lX67A04Nuv4YIN8OZNXLAxAy9Cb8enjUtxCe51HS6/oxG92', 'Elliot', 'Anderson', 'male', '1995-11-11', '2024-09-03 12:30:55'),
(19, 'dimin', '$2y$10$fdudOzSQSP525S1G5LbW/.oVTjhPuaMetB7Si3hjVogck5YsNrAWe', 'Dima', 'Dimin', 'male', '2002-02-22', '2024-09-03 12:32:29'),
(21, 'ivan', '$2y$10$i7CPWtK3GuTRW9Qw7hHIGOdSBLhowuWAbfI12cJwKPH4ZP2fJLOz.', 'Ivan', 'Ivanov', 'male', '2014-04-04', '2024-09-03 12:33:44'),
(23, 'hook', '$2y$10$LScOdPWloqp1BXCMeYJnIubDRT4w5czZVM1SjBYzho7syCkO7C6re', 'Dendy', 'Pudge', 'male', '2014-02-22', '2024-09-03 12:36:21'),
(24, 'elena', '$2y$10$Qs0D262Xylo9io2.h3uoo.HA1ys8KAr4Lt8rQaJFBdUXaUG912n8S', 'Elena', 'Elenina', 'female', '2001-02-22', '2024-09-03 12:52:30'),
(25, 'pavel', '$2y$10$n7XhdYVrXaVGND81.GyoW.s6mDfBLK/tZV2NHYU/JhcjcIxxVNYTy', 'Pavel', 'Technique', 'male', '1990-02-22', '2024-09-03 12:53:33');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
