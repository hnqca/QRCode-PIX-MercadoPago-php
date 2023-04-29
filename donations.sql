-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Abr-2023 às 00:02
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `donation2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `id_reference` varchar(255) NOT NULL,
  `nickname` varchar(75) NOT NULL,
  `email` varchar(125) NOT NULL,
  `message` varchar(450) DEFAULT NULL,
  `status` varchar(35) NOT NULL,
  `value` float NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `donations`
--

INSERT INTO `donations` (`id`, `id_reference`, `nickname`, `email`, `message`, `status`, `value`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$WWqeHQWNNfhh4i/oU616huFLw4MdFo6573XFsCETBcR5Oakb4RIxa', 'Henrique', 'hnq@teste.com', 'teste!', 'approved', 1.5, '2023-04-29 18:36:40', '2023-04-29 18:36:40'),
(2, '$2y$10$kn0CKrAWBAyYXIizZGpXHer/e39gB9Yk3Q95R7COgwhS423YZ7JVq', 'Testador', 'teste@gmail.com', '', 'approved', 0.25, '2023-04-29 19:02:41', '2023-04-29 19:36:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
