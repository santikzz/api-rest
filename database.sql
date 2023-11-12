-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 11:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tudai`
--

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

CREATE TABLE `genero` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`id`, `nombre`) VALUES
(1, 'Action'),
(3, 'Fiction'),
(4, 'Suspense'),
(6, 'Animation'),
(11, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `pelicula`
--

CREATE TABLE `pelicula` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `id_genero` int(11) NOT NULL,
  `autor` text NOT NULL,
  `estudio` text NOT NULL,
  `duracion` text NOT NULL,
  `descripcion` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelicula`
--

INSERT INTO `pelicula` (`id`, `nombre`, `id_genero`, `autor`, `estudio`, `duracion`, `descripcion`, `image`) VALUES
(2, 'Indiana Jones', 6, 'Steven Steven Spielberg', '', '', '', 'images/609df06d7c2b5fb3125f16a7e4e34152.jpg'),
(9, 'back to the future', 1, 'Steven Spielberg', '', '', '', 'https://andrew-hankinson.co.uk/wp-content/uploads/2015/10/1042136_1338502907783_full-e1444587343951.jpg'),
(10, 'Los Simpsons la Pelicula', 6, 'Matt Groening', '', '', '', 'http://www.lardlad.com/assets/wallpaper/simpsons1920.jpg'),
(11, 'Peaky Blinders', 3, 'Steven Knight', '', '', '', 'http://www.lardlad.com/assets/wallpaper/simpsons1920.jpg'),
(13, 'Scary Movie', 4, 'Shawn Wayans', '', '', '', 'https://streamcoimg-a.akamaihd.net/000/136/9860/1369860-PosterArt-fbc02dce7486c2af10290978add8046a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`, `email`, `isAdmin`) VALUES
(1, 'admin', '$2y$10$bfFoXlJcMiyKbZxpDAx14.i3eIgDrxKoOfvJlYIo/C.FkdJv5WsoS', 'admin@webmaster.com', 1),
(2, 'santi', '$2y$10$bfFoXlJcMiyKbZxpDAx14.i3eIgDrxKoOfvJlYIo/C.FkdJv5WsoS', 'santiago_bugnon@hotmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_genero` (`id_genero`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pelicula`
--
ALTER TABLE `pelicula`
  ADD CONSTRAINT `pelicula_ibfk_1` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
