-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2023 at 10:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `produtos_crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` float NOT NULL,
  `quantidade` int(11) NOT NULL,
  `id_venda` int(11) DEFAULT NULL,
  `anexo_produto` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `quantidade`, `id_venda`, `anexo_produto`) VALUES
(75, '1venda1produto', 1, 1, 69, 'images/jTm0bfsq/halloween-candy-gaed1598a5_640.jpg'),
(76, '1venda2prodtuo', 2, 2, 69, 'images/9aopLWHD/imageproduto.png'),
(79, '2', 2, 2, 71, 'images/4NK83hCn/small.png'),
(80, '3', 3, 3, 71, 'images/KZTDVOZw/imageproduto.png'),
(88, '22', 22, 22, 75, 'images/eLD7TRqb/xcv.jpg'),
(89, 'outroproduto', 2, 2, 75, 'images/8xhYpK6G/download (3).jfif'),
(90, '2', 2, 2, 76, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `tipo_pagamento` varchar(255) NOT NULL,
  `data_venda` date NOT NULL,
  `num_nota` varchar(255) NOT NULL,
  `obs` text DEFAULT NULL,
  `anexo_venda` varchar(2048) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendas`
--

INSERT INTO `vendas` (`id`, `tipo_pagamento`, `data_venda`, `num_nota`, `obs`, `anexo_venda`, `data_registro`) VALUES
(69, 'Cartão de Crédito', '2023-02-09', '2021', 'edit', 'images/YR8UjvVV/WIN_20230121_10_33_59_Pro.jpg', '2023-02-22 21:40:44'),
(71, 'Dinheiro', '2023-02-24', '3', 'vendaatualizada', 'images/ri4OEThg/Hotpot.png', '2023-02-23 01:45:02'),
(75, 'Cartão de Crédito', '2023-02-16', '222', '222', 'images/6ia74qOK/halloween-candy-gaed1598a5_640.jpg', '2023-02-23 01:33:23'),
(76, 'Cartão de Débito', '2023-02-15', '2', '2', '', '2023-02-23 01:39:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vendas` (`id_venda`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_vendas` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
