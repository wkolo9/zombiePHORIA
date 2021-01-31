-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Sty 2021, 14:13
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zombiephoria`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `lvl` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `lvl_glock` int(11) NOT NULL,
  `lvl_sniper` int(11) NOT NULL,
  `lvl_awp` int(11) NOT NULL,
  `lvl_heavy` int(11) NOT NULL,
  `lvl_minigun` int(11) NOT NULL,
  `lvl_speedy` int(11) NOT NULL,
  `lvl_smg` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `devotion_lvl` int(11) NOT NULL,
  `chosen_class` int(11) NOT NULL,
  `logged_in` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `user`, `login`, `pass`, `email`, `lvl`, `currency`, `lvl_glock`, `lvl_sniper`, `lvl_awp`, `lvl_heavy`, `lvl_minigun`, `lvl_speedy`, `lvl_smg`, `xp`, `devotion_lvl`, `chosen_class`, `logged_in`) VALUES
(1, 'WoXuS', 'adam', 'qwerty', 'adam@gmail.com', 0, 0, 0, 13, 10, 2, 2, 25, 1, 37, 1, 0, 1),
(2, 'maro13', 'marek', 'asdfg', 'marek@gmail.com', 24, 1100, 0, 2, 0, 15, 0, 0, 0, 1, 3, 0, 0),
(3, 'anka', 'anna', 'zxcvb', 'anna@gmail.com', 36, 100, 0, 1, 0, 5, 0, 0, 0, 1, 2, 0, 0),
(4, 'andrewGolara', 'andrzej', 'asdfg', 'andrzej@gmail.com', 65, 200, 0, 1, 0, 0, 0, 0, 0, 1, 2, 0, 0),
(5, 'justyś15', 'justyna', 'yuiop', 'justyna@gmail.com', 45, 900, 0, 5, 0, 0, 0, 0, 0, 1, 5, 0, 0),
(6, 'kasiox', 'kasia', 'hjkkl', 'kasia@gmail.com', 26, 900, 0, 9, 0, 12, 0, 0, 0, 1, 7, 0, 0),
(7, 'beti69', 'beata', 'fgthj', 'beata@gmail.com', 55, 300, 0, 4, 0, 7, 0, 0, 0, 1, 2, 0, 0),
(8, 'jacob420', 'jakub', 'ertyu', 'jakub@gmail.com', 24, 500, 0, 8, 0, 0, 0, 0, 0, 1, 3, 0, 0),
(9, 'marofrajer', 'janusz', 'cvbnm', 'janusz@gmail.com', 65, 400, 0, 4, 0, 0, 0, 0, 0, 1, 0, 0, 0),
(10, 'romekxd', 'roman', 'dfghj', 'roman@gmail.com', 97, 200, 0, 4, 0, 23, 0, 0, 0, 1, 0, 0, 0),
(16, 'Najman', 'najek13xx', '12345678', 'najman.marcin@gmail.com', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0),
(20, 'nickname', 'login', 'haslo12345', 'email@gmail.com', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0),
(26, 'przyklad', 'przykladowylogin', '12345678', 'mail@gmail.com', 0, 20000, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0),
(27, 'xdxdxdxd', '12345678', '12345678', 'galeris1233@interia.pl', 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
