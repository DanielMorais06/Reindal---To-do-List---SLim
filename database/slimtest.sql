-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Maio-2024 às 11:53
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `slimtest`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorys`
--

CREATE TABLE `categorys` (
  `id_category` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorys`
--

INSERT INTO `categorys` (`id_category`, `id_user`, `name`) VALUES
(55, 18, 'Andebol');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tasks`
--

CREATE TABLE `tasks` (
  `id_task` int(30) NOT NULL,
  `id_user` int(30) DEFAULT NULL,
  `title` varchar(400) DEFAULT NULL,
  `description` varchar(900) DEFAULT NULL,
  `category` int(11) NOT NULL,
  `final_date` date NOT NULL,
  `Completed` tinyint(1) NOT NULL,
  `File` varchar(900) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tasks`
--

INSERT INTO `tasks` (`id_task`, `id_user`, `title`, `description`, `category`, `final_date`, `Completed`, `File`) VALUES
(104, 18, 'trfgv', 'hytrfg', 55, '2024-05-30', 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id_user` int(30) NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `name`) VALUES
(18, 'ni2006morais@gmail.com', 'DanielMorais06', 'Daniel Alexandre de Oliveria Morais');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`id_category`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `id_utilizador` (`id_user`),
  ADD KEY `category` (`category`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorys`
--
ALTER TABLE `categorys`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id_task` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `categorys`
--
ALTER TABLE `categorys`
  ADD CONSTRAINT `categorys_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Limitadores para a tabela `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `tasks_ibfk_4` FOREIGN KEY (`category`) REFERENCES `categorys` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
