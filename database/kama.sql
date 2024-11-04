-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 16 2024 г., 09:51
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kama`
--

-- --------------------------------------------------------

--
-- Структура таблицы `artists`
--

CREATE TABLE `artists` (
  `artist_id` int NOT NULL,
  `name_artist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `about_artist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo_artist` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role_id` int DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `artists`
--

INSERT INTO `artists` (`artist_id`, `name_artist`, `about_artist`, `photo_artist`, `role_id`, `email`) VALUES
(18, 'Иван Иванов', 'Родился тогда-то в где-то', '', 2, 'ivanov@mail.com'),
(38, 'Карим Каримов', 'Художник. Ничего нового', NULL, 2, 'hudozhnik@bullery'),
(42, 'Тагир Аглиуллин', 'Родился в Альметьевске. Студент АПТ', NULL, 2, 'agliullin@bullery');

-- --------------------------------------------------------

--
-- Структура таблицы `bids`
--

CREATE TABLE `bids` (
  `bid_id` int NOT NULL,
  `lot_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` int NOT NULL,
  `bid_time` timestamp NOT NULL,
  `status` enum('active','won','lost') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `winning_bid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `bids`
--

INSERT INTO `bids` (`bid_id`, `lot_id`, `user_id`, `amount`, `bid_time`, `status`, `winning_bid`) VALUES
(1, 2, 5, 60000, '2024-04-06 03:35:31', 'active', 0),
(2, 2, 5, 75000, '2024-04-06 03:35:45', 'active', 0),
(3, 2, 5, 12000, '2024-04-06 03:37:28', 'active', 0),
(4, 2, 5, 70000, '2024-04-06 10:49:52', 'active', 0),
(5, 3, 5, 70000, '2024-04-06 10:50:16', 'active', 0),
(6, 2, 5, 13, '2024-04-06 10:52:55', 'active', 0),
(7, 2, 5, 15001, '2024-04-06 10:57:38', 'active', 0),
(8, 11, 5, 13000, '2024-04-16 06:50:14', 'active', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Самая большая ставка за картину!'),
(5, 'Пам-пам!'),
(6, 'Работаем!');

-- --------------------------------------------------------

--
-- Структура таблицы `lots`
--

CREATE TABLE `lots` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_price` decimal(10,2) NOT NULL,
  `current_price` decimal(10,2) DEFAULT '0.00',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'active',
  `owner_id` int NOT NULL,
  `category_id` int NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '2023-12-31 21:00:00',
  `current_bid` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `lots`
--

INSERT INTO `lots` (`id`, `title`, `description`, `image`, `start_price`, `current_price`, `status`, `owner_id`, `category_id`, `start_time`, `end_time`, `current_bid`) VALUES
(6, 'Розыгрыш', 'Описание лота', '30', '35000.00', '0.00', 'inactive', 5, 5, '2024-04-16 06:26:27', '2024-04-17 06:27:00', '0.00'),
(7, 'Пампам', 'пампам', '29', '42353.00', '0.00', 'inactive', 5, 6, '2024-04-16 06:32:31', '2024-04-17 06:32:00', '0.00'),
(8, 'Пам пам', 'пам пам', '30', '54500.00', '0.00', 'inactive', 5, 6, '2024-04-16 06:36:02', '2024-04-17 06:35:00', '0.00'),
(9, 'Пам пам', 'пам пам', '30', '54500.00', '0.00', 'inactive', 5, 6, '2024-04-16 06:43:37', '2024-04-17 06:35:00', '0.00'),
(10, 'Проверка', 'Проверка', '36', '15000.00', '0.00', 'inactive', 5, 6, '2024-04-16 06:44:59', '2024-04-17 06:44:00', '0.00'),
(11, 'уа уауау', 'уауауа', '36', '12000.00', '0.00', 'active', 5, 6, '2024-04-16 06:49:37', '2024-04-17 06:49:00', '0.00');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `painting_id` int NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `paintings`
--

CREATE TABLE `paintings` (
  `id` int NOT NULL,
  `lot_id` int DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `size_paint` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `izbran` int DEFAULT NULL,
  `date` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `audio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('ожидает','утверждено','отклонено') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'ожидает',
  `style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `paintings`
--

INSERT INTO `paintings` (`id`, `lot_id`, `artist_id`, `title`, `price`, `size_paint`, `image`, `izbran`, `date`, `description`, `audio`, `status`, `style`) VALUES
(29, NULL, 18, 'Настроение 24', 15000, '100х100', 'painting1.jpg', 2, '2019', '\"Настроение 24\" - это картина, насыщенная эмоциональным напряжением и внутренним диалогом. В ней художник Иван Иванов представил зрителю мозаику человеческих состояний, воплотив их в разнообразных цветовых оттенках и абстрактных формах.', NULL, 'ожидает', 'Абстракционизм'),
(30, 8, 38, 'Северные сны', 34000, '70х60', 'painting2.jpg', 2, '2021', '\"Северные сны\" от Карима Каримова - величественное воплощение арктической красоты. Мерцающие льды, таинственные оттенки северного неба и пленительные лучи северного сияния создают впечатление невероятного волшебства и умиротворения.', NULL, 'утверждено', 'Реализм'),
(31, NULL, 38, 'Секретики', 14690, '70х20', 'painting5.jpg', 1, '2019', '\"Секретики\" - это произведение, в котором Карим Каримов изображает двух девушек в интимной беседе, окруженных природой, наполненной загадками. Мягкие краски и утонченные детали создают атмосферу доверительности и таинственности.', NULL, 'утверждено', 'Абстракционизм'),
(32, NULL, 38, 'Армагеддон', 82990, '80х80', 'painting6.jpeg', 2, '2024', '\"Армагеддон\" - Карим Каримов, 2024. Величественное представление катастрофы, заставляющее зрителя задуматься о роли человека во Вселенной и последствиях его действий.', NULL, 'ожидает', 'Абстракционизм'),
(34, NULL, 42, 'SILENCE', 19990, '130х140', 'painting7.jpg', 1, '2021', '\"SILENCE\"(2021) - картина, в которой художник зафиксировал момент тишины и спокойствия в суете современного мира. Через минималистичные образы и пастельные тона он передает эмоциональную глубину момента, приглашая зрителя погрузиться в свой внутренний мир', NULL, 'ожидает', 'Реализм'),
(35, NULL, 42, 'Sleep', 9500, '50х60', 'painting8.jpg', 1, '2021', '\"Sleep\" Тагира Аглиуллина (2021) - картина, в которой художник запечатлел трансформацию в мире снов. Сквозь эмоциональные переливы и мягкие контуры он передает атмосферу покоя и глубину подсознания, приглашая зрителя на путешествие в мир сновидений.', NULL, 'утверждено', 'Реализм'),
(36, 11, 42, 'FLOWERS OF WAR', 7200, '58х80', 'painting9.jpg', 1, '2019', '\"FLOWERS OF WAR\" Тагира Аглиуллина (2019) - девушка, окруженная бабочками, символизирует надежду и красоту во время войны. Картина передает контраст между разрухой и хрупкой красотой, напоминая о возможности найти свет в самых темных временах.', NULL, 'утверждено', 'Абстракционизм'),
(37, NULL, 42, '//wax drms', 13000, '20х25', 'painting10.jpg', 1, '2022', '\"//wax drms\" Тагира Аглиуллина (2022) - картина, где художник погружает зрителя в мир сновидений, используя цифровые коды и абстрактные формы. Это визуальное путешествие в глубины подсознания, где реальность переплетается с фантазией.', NULL, 'ожидает', 'Абстракционизм'),
(38, NULL, 42, 'После меня', 65750, '21х29', 'painting11.jpg', 2, '2024', '\"После меня\" Тагира Аглиуллина (2024) - картина, в которой художник зафиксировал эфемерность времени и преходящую природу бытия. Через смелое сочетание цветов и форм он передает ощущение непрерывного потока жизни.', NULL, 'утверждено', 'Реализм'),
(39, NULL, 42, 'Сумерки. Гроза.Правая часть диптиха', 156000, '30х50', 'painting12.jpg', 1, '2020', '\"Сумерки. Гроза. Правая часть диптиха\" Тагира Аглиуллина (2022) - картина, в которой художник передает мощь и величие природного явления. Через драматические контрасты и динамичные мазки он воплощает силу природы', NULL, 'утверждено', 'Реализм');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `role_id` int NOT NULL,
  `name_role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`role_id`, `name_role`) VALUES
(1, 'Пользователь'),
(2, 'Художник'),
(3, 'Админ');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profile_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL,
  `profile_photo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT './assets/img/default_photo_profile.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `profile_photo`, `email`, `password`, `role_id`, `profile_photo_path`) VALUES
(1, 'Артур', 'Анзаев', NULL, 'dsadsad@saddasd', '$2y$10$I2s0vuWve9QLtRAlJdqTMOaZVD.7iQf.zkc4mZzsAXB/ldCaPFIpi', 1, ''),
(2, 'Артур', 'Анзаев', NULL, 'artur@mail.com', '$2y$10$QAylIfR43DCM0sSq4CZZqO/Qc7klsp2IhShd9Fmo7kj9yEpgTEA5q', 1, ''),
(5, 'Админ', 'Админ', NULL, 'admin@bullery', '$2y$10$qbVHL2fK1Ib1XAC6UuEhj.dCvdySxV1onyKlFrKQAw890JihycVBi', 3, ''),
(18, 'Иван', 'Иванов', NULL, 'ivanov@mail.com', '$2y$10$QLgDL8F5oZGL28J04RAasOqbYIK4GPicn4syTXK/myijbMYxCKS8q', 2, './assets/img/uploads/painting7.jpg'),
(38, 'Карим', 'Каримов', NULL, 'hudozhnik@bullery', '$2y$10$anlPCF9b7rXtzhxOLTlAC.q7YCwcfH4nI5Gld4hr8EhlT6pmY2wwG', 2, './assets/img/default_photo_profile.jpg'),
(42, 'Тагир', 'Аглиуллин', NULL, 'agliullin@bullery', '$2y$10$ByvoejR1TS.Z0EjkSkaNMODfnq71QyyAq8MUykfvcaO6V6PrgfgXi', 2, './assets/img/default_photo_profile.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`),
  ADD KEY `fk_role_id` (`role_id`),
  ADD KEY `fk_email_artist` (`email`);

--
-- Индексы таблицы `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`bid_id`);

--
-- Индексы таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_id_orders` (`user_id`),
  ADD KEY `fk_painting_id` (`painting_id`);

--
-- Индексы таблицы `paintings`
--
ALTER TABLE `paintings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `fk_lot_id` (`lot_id`),
  ADD KEY `image_index` (`image`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `bids`
--
ALTER TABLE `bids`
  MODIFY `bid_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `paintings`
--
ALTER TABLE `paintings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `artists`
--
ALTER TABLE `artists`
  ADD CONSTRAINT `fk_email_artist` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`artist_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `paintings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lots_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_painting_id` FOREIGN KEY (`painting_id`) REFERENCES `paintings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id_orders` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `paintings`
--
ALTER TABLE `paintings`
  ADD CONSTRAINT `fk_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_lot_id` FOREIGN KEY (`lot_id`) REFERENCES `lots` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `paintings_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
