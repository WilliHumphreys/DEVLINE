-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Nov-2023 às 20:42
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `devline`
--

CREATE DATABASE devline;

USE devline;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

CREATE TABLE `adm` (
  `id_adm` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `dt_nascimento` varchar(10) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `adm`
--

INSERT INTO `adm` (`id_adm`, `nome`, `dt_nascimento`, `usuario`, `email`, `cpf`, `senha`) VALUES
(1, 'willi', '28/07/2004', 'Willi_adm', 'willighn469@gmail.com', '515.210.418-06', '1eba8263edb65af319b8d74cce5f953aed0d7cde');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `id_aluno` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `dt_nascimento` varchar(10) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `nivel` varchar(8) NOT NULL,
  `ft_perfil` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `dvbucks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome`, `dt_nascimento`, `usuario`, `email`, `cpf`, `senha`, `nivel`, `ft_perfil`, `rank`, `dvbucks`) VALUES
(1, 'Willi', '28/07/2004', 'Willighn', 'willighn469@gmail.com', '515.210.418-06', '1eba8263edb65af319b8d74cce5f953aed0d7cde', 'Default', '1700220025.gif', 0, 0),
(2, 'Giovanna', '05/04/2006', 'Gigi_linda', 'giovanna.ferreira93@etec.sp.gov.br', '537.718.128-01', 'c891db8d8d11373950e6148053ce8a8418b8117b', 'Default', 'PROFILE_AVATAR_09.png', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacotes`
--

CREATE TABLE `pacotes` (
  `id_pack` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `promo` varchar(10) NOT NULL,
  `preco` varchar(10) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `acessos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `pacotes`
--

INSERT INTO `pacotes` (`id_pack`, `nome`, `promo`, `preco`, `descricao`, `acessos`) VALUES
(1, 'DV Basic', 'GRATUITO', '', 'Dê o primeiro passo em direção ao sucesso online com o DV Basic.', 'POSITIVO?POSITIVO?NEGATIVO?NEGATIVO?NEGATIVO'),
(2, 'DV Pro', 'R$ 259,00', 'R$ 150,00', 'Eleve suas ambições digitais com o DV Pro. Projetado para inovadores que buscam destacar-se na multidão.', 'POSITIVO?POSITIVO?POSITIVO?POSITIVO?NEGATIVO'),
(3, 'DV Elite', 'R$ 499,00', 'R$ 250,00', 'A culminação da excelência digital está no DV Elite. Para líderes que aspiram à grandeza, este pacote oferece uma experiência incomparável.', 'POSITIVO?POSITIVO?POSITIVO?POSITIVO?POSITIVO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professor`
--

CREATE TABLE `professor` (
  `id_professor` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `dt_nascimento` varchar(10) NOT NULL,
  `usuario` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `especialidade` varchar(20) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Extraindo dados da tabela `professor`
--

INSERT INTO `professor` (`id_professor`, `nome`, `dt_nascimento`, `usuario`, `email`, `cpf`, `senha`, `especialidade`, `status`) VALUES
(1, 'Giovanna', '05/04/2006', '0286dd552c9bea9a69ecb3759e7b94777635514b', 'giovanna.ferreira93@etec.sp.gov.br', '537.718.128-01', 'f6e1126cedebf23e1463aee73f9df08783640400', 'BANCO DE DADOS', 'CRIANDO'),
(2, 'Willi', '28/07/2004', 'Willi_prof', 'willighn469@gmail.com', '515.210.418-06', '1eba8263edb65af319b8d74cce5f953aed0d7cde', 'DEV FRONT-END', 'MONITORANDO');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `adm`
--
ALTER TABLE `adm`
  ADD PRIMARY KEY (`id_adm`);

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id_aluno`);

--
-- Índices para tabela `pacotes`
--
ALTER TABLE `pacotes`
  ADD PRIMARY KEY (`id_pack`);

--
-- Índices para tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id_professor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `adm`
--
ALTER TABLE `adm`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pacotes`
--
ALTER TABLE `pacotes`
  MODIFY `id_pack` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
