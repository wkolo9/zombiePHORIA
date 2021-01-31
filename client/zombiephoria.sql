-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Sty 2021, 16:28
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
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `lvl` int(11) NOT NULL,
  `currency` int(11) NOT NULL,
  `lvl_sniper` int(11) NOT NULL,
  `lvl_heavy` int(11) NOT NULL,
  `user` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `login`, `pass`, `email`, `lvl`, `currency`, `lvl_sniper`, `lvl_heavy`, `user`) VALUES
(1, 'adam', 'qwerty', 'adam@gmail.com', 213, 5675, 342, 0, 'WoXuS'),
(2, 'marek', 'asdfg', 'marek@gmail.com', 324, 1123, 4325, 15, 'maro13'),
(3, 'anna', 'zxcvb', 'anna@gmail.com', 4536, 17, 120, 25, 'anka'),
(4, 'andrzej', 'asdfg', 'andrzej@gmail.com', 5465, 132, 189, 0, 'andrewGolara'),
(5, 'justyna', 'yuiop', 'justyna@gmail.com', 245, 890, 554, 0, 'justyś15'),
(6, 'kasia', 'hjkkl', 'kasia@gmail.com', 267, 980, 109, 12, 'kasiox'),
(7, 'beata', 'fgthj', 'beata@gmail.com', 565, 356, 447, 77, 'beti69'),
(8, 'jakub', 'ertyu', 'jakub@gmail.com', 2467, 557, 876, 0, 'jacob420'),
(9, 'janusz', 'cvbnm', 'janusz@gmail.com', 65, 456, 2467, 0, 'marofrajer'),
(10, 'roman', 'dfghj', 'roman@gmail.com', 97, 226, 245, 23, 'romekxd'),
(16, 'najek13xx', '12345678', 'najman.marcin@gmail.com', 1, 0, 0, 0, 'Najman'),
(17, 'krzysiek13', 'opensource', 'krzysiek@podlesie.pl', 1, 0, 0, 0, 'krzykox');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
